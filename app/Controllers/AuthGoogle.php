<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Myth\Auth\Models\UserModel;
use Google_Client;
use Google_Service_Oauth2;

class AuthGoogle extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setClientId('644895794102-ascftgh1gv53snks5n1q7f4u95ab0jae.apps.googleusercontent.com'); // Replace with your actual Client ID
        $this->client->setClientSecret('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'); // Replace with your actual Client Secret
        $this->client->setRedirectUri(base_url('authgoogle/callback'));
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function login()
    {
        return redirect()->to($this->client->createAuthUrl());
    }

    public function callback()
    {
        $service = new \Google_Service_Oauth2($this->client);

        if ($code = service('request')->getGet('code')) {
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            $this->client->setAccessToken($token);

            $googleUser = $service->userinfo->get();
            $email = $googleUser->email;
            $username = explode('@', $email)[0];
            $name = $googleUser->name ?? '';
            $avatar = $googleUser->picture ?? 'default.jpg';

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            helper('auth');

            if ($user) {
                // Update the user's profile with Google data
                $userModel->update($user->id, [
                    'name' => $name,
                    'profile_picture' => $avatar // Assuming you have a 'profile_picture' column
                ]);
            } else {
                $inserted = $userModel->insert([
                    'email'    => $email,
                    'username' => $username,
                    'name'     => $name,
                    'profile_picture' => $avatar, // Assuming you have a 'profile_picture' column
                    'password' => password_hash('google_secret_password', PASSWORD_DEFAULT),
                    'active'   => 1,
                ]);

                if (!$inserted) {
                    // Log the error for debugging
                    log_message('error', 'Failed to register user: ' . json_encode($userModel->errors()));
                    return redirect()->to('/login')->with('error', 'Failed to register user.');
                }

                $user = $userModel->where('email', $email)->first();
            }

            $auth = service('authentication');
            // Directly log in the user by their ID
            $auth->loginById($user->id);

            return redirect()->to('/');
        }

        return redirect()->to('/login');
    }

    public function register()
    {
        $oauthData = session()->get('oauth_google');

        if (!$oauthData) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();

        $userModel->insert([
            'email'    => $oauthData['email'],
            'username' => explode('@', $oauthData['email'])[0],
            'password' => password_hash('google_secret_password', PASSWORD_DEFAULT),
            'active'   => 1,
        ]);

        session()->remove('oauth_google');

        helper('auth');
        $auth = service('authentication');
        $auth->attempt([
            'email'    => $oauthData['email'],
            'password' => 'google_secret_password',
        ], false);

        return redirect()->to('/');
    }
}
