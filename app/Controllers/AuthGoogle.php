<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel; // Use your application's UserModel
use Google_Client;
use Google_Service_Oauth2;

class AuthGoogle extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(getenv('google.clientId')); // Get from .env file
        $this->client->setClientSecret(getenv('google.clientSecret')); // Get from .env file
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
        $service = new Google_Service_Oauth2($this->client);

        if ($code = service('request')->getGet('code')) {
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            $this->client->setAccessToken($token);

            $googleUser = $service->userinfo->get();

            $userModel = new UserModel();
            $user = $userModel->where('email', $googleUser->email)->first();

            helper('auth');
            helper('text');

            if (!$user) {
                // --- Username collision handling ---
                $baseUsername = explode('@', $googleUser->email)[0];
                $username = $baseUsername;
                $i = 1;
                while ($userModel->where('username', $username)->first()) {
                    $username = $baseUsername . $i++;
                }
                // --- End of username collision handling ---

                // Use a secure, random password for social logins.
                // Myth/Auth's UserModel will hash this automatically.
                $password = random_string('crypto', 32);

                $userEntity = new \App\Entities\User([ // Use your application's User entity
                    'email'    => $googleUser->email,
                    'username' => $username,
                    'password' => $password,
                    'active'   => 1, // Set user as active
                    'avatar'   => $googleUser->picture, // Save the Google profile picture URL
                ]);

                if ($userModel->save($userEntity) === false) {
                    // Log the error for debugging
                    log_message('error', 'Failed to register user via Google: ' . json_encode($userModel->errors()));
                    return redirect()->to('/login')->with('error', lang('Auth.registerFailure'));
                }

                // More efficient to find the user by their newly created ID.
                $userId = $userModel->getInsertID();
                $user = $userModel->find($userId);

                // Add the user to the default 'user' group.
                // Assumes 'user' group has ID 1.
                $userModel->addToGroup($user->id, 1);
            } else {
                // User exists, update avatar if it has changed.
                if ($user->avatar !== $googleUser->picture) {
                    $userModel->update($user->id, ['avatar' => $googleUser->picture]);
                }
            }

            $auth = service('authentication');
            // Directly log in the user by their ID
            $auth->loginById($user->id);

            return redirect()->to('/');
        }

        return redirect()->to('/login');
    }
}
