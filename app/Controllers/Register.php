<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Entities\User;
use Myth\Auth\Authorization\GroupModel;

class Register extends Controller
{
    protected $auth;
    protected $config;

    public function __construct()
    {
        // Get auth config
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    /**
     * Displays the registration form.
     * You should create a view for this, e.g., app/Views/auth/register.php
     */
    public function index()
    {
        // Example: return view('auth/register');
    }

    /**
     * Displays the form to resend an activation email.
     */
    public function showResend()
    {
        $villageModel = model('App\Models\VillageModel');
        $data['village'] = $villageModel->where('selected', '1')->first();
        $data['title'] = 'Resend Activation';

        return view('auth/resend_activation', $data);
    }

    /**
     * Attempt to register a new user.
     */
    public function attemptRegister()
    {
        // Get the User Provider (UserModel)
        $users = model('App\Models\UserModel');

        // Validate user input
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Create the new user ---
        $user = new User($this->request->getPost());

        // Generate a random activation hash
        $user->generateActivateHash();

        // Set activation expiration time (10 minutes from now)
        $user->activate_expires = date('Y-m-d H:i:s', time() + 600);

        // Ensure user is not active until email is verified
        $user->active = 0;

        if (! $users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // --- Send the activation email ---
        // Load the helper that contains the sendEmailWithPHPMailer function.
        require_once APPPATH . 'Helpers/PHPMailerHelper.php';

        $subject = 'Account Activation';
        $message = view('web/layouts/email_activation', [
            'hash' => $user->activate_hash,
        ]);

        // The sendEmailWithPHPMailer helper is assumed to return true on success, false on failure.
        if (! sendEmailWithPHPMailer($user->email, $subject, $message)) {
            log_message('error', 'Failed to send activation email to: ' . $user->email . ' using PHPMailer.');
            return redirect()->back()->withInput()->with('error', 'Failed to send activation email. Please try again later.');
        }

        // Success!
        return redirect()->to('/login')->with('message', 'Registration successful! Please check your email to activate your account.');
    }

    /**
     * Attempt to resend an activation email.
     */
    public function attemptResend()
    {
        // Get the User Provider (UserModel)
        $users = model('App\Models\UserModel');

        // Validate user input
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $users->where('email', $this->request->getPost('email'))->first();

        // User not found in the database.
        if (is_null($user)) {
            return redirect()->back()->with('error', 'That email address is not registered.');
        }

        // User is already active.
        if ($user->active) {
            return redirect()->to('/login')->with('message', 'Your account has already been activated. You can log in.');
        }

        // User found and is not active, resend the email.
        $user->generateActivateHash();
        $user->activate_expires = date('Y-m-d H:i:s', time() + 600);

        if ($users->save($user)) {
            // Load the helper that contains the sendEmailWithPHPMailer function.
            require_once APPPATH . 'Helpers/PHPMailerHelper.php';

            $subject = 'Account Activation';
            $message = view('web/layouts/email_activation', ['hash' => $user->activate_hash]);

            sendEmailWithPHPMailer($user->email, $subject, $message);

            return redirect()->to('/login')->with('message', 'A new activation link has been sent to your email.');
        }

        // Fallback for a database save error.
        return redirect()->back()->withInput()->with('error', 'We could not process your request. Please try again later.');
    }

    /**
     * Activate a user's account.
     */
    public function activateAccount(string $hash = null)
    {
        if (empty($hash)) {
            return redirect()->to('/login')->with('error', 'No activation hash provided.');
        }

        $users = model('App\Models\UserModel');
        $user = $users->where('activate_hash', $hash)->first();

        if (is_null($user)) {
            return redirect()->to('/login')->with('error', 'This activation link is invalid.');
        }

        // Account is already active.
        if ($user->active) {
            return redirect()->to('/login')->with('message', 'Your account has already been activated.');
        }

        // Check if the hash has expired
        if (is_null($user->activate_expires) || strtotime($user->activate_expires) < time()) {
            return redirect()->to('/login')->with('error', 'This activation link has expired. Please register again.');
        }

        // Activate the user
        $user->active = 1;
        $user->activate_hash = null;
        $user->activate_expires = null;

        $users->save($user);

        // Add user to the 'user' group by default
        $groupModel = new GroupModel();
        $userGroup = $groupModel->where('name', 'user')->first();

        if ($userGroup) {
            $users->addToGroup($user->id, $userGroup->id);
        }

        return redirect()->to('/login')->with('message', 'Account activated successfully! You can now log in.');
    }
}
