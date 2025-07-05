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
        $this->client->setClientId('644895794102-ascftgh1gv53snks5n1q7f4u95ab0jae.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri(base_url('authgoogle/callback'));
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function login()
    {
        return redirect()->to($this->client->createAuthUrl());
    }

    // public function login()
    // {
    //     $client = new Google_Client();
    //     $client->setClientId('644895794102-ascftgh1gv53snks5n1q7f4u95ab0jae.apps.googleusercontent.com');
    //     $client->setClientSecret('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');
    //     $client->setRedirectUri(base_url('authgoogle/callback'));
    //     $client->addScope('email');
    //     $client->addScope('profile');

    //     return redirect()->to($client->createAuthUrl());
    // }

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

            if (!$user) {
                $inserted = $userModel->insert([
                    'email'         => $email,
                    'username'      => $username,
                    'password'      => 'google_secret_password',
                    'active'        => 1,
                ]);
                if (!$userModel->insert($inserted)) {
                    dd('Insert error', $userModel->errors());
                } else {
                    dd('Insert success!', $inserted);
                }
                if (!$inserted) {
                    dd($userModel->errors());
                }

                $user = $userModel->where('email', $email)->first();
            }
            // if (!$user) {
            //     // Belum terdaftar, redirect ke halaman registrasi Google
            //     session()->set('oauth_google', [
            //         'email' => $email,
            //         'name' => $googleUser->name,
            //     ]);
            //     return redirect()->to('/authgoogle/register');
            // }

            // Sudah terdaftar, login
            $auth = service('authentication');
            $success = $auth->attempt([
                'email'    => $email,
                'password' => 'google_secret_password'
            ]);

            if (!$success) {
                dd('Login gagal', $auth->error());
            }

            return redirect()->to('/');
        }

        return redirect()->to('/login');
    }
    // public function callback()
    // {
    //     $client = new Google_Client();
    //     $client->setClientId('644895794102-ascftgh1gv53snks5n1q7f4u95ab0jae.apps.googleusercontent.com');
    //     $client->setClientSecret('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');
    //     $client->setRedirectUri(base_url('authgoogle/callback'));

    //     $service = new Google_Service_Oauth2($client);

    //     if ($code = service('request')->getGet('code')) {
    //         $token = $client->fetchAccessTokenWithAuthCode($code);
    //         $client->setAccessToken($token);

    //         $googleUser = $service->userinfo->get();
    //         $email = $googleUser->email;
    //         $username = explode('@', $email)[0];

    //         $userModel = new UserModel();
    //         $user = $userModel->where('email', $email)->first();

    //         // Password tetap untuk Google user
    //         $defaultGooglePassword = 'google_secret_password';
    //         $hashedPassword = password_hash($defaultGooglePassword, PASSWORD_DEFAULT);

    //         // $defaultPassword = 'google_secret';
    //         // $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);

    //         if (!$user) {
    //             $userModel->insert([
    //                 'email'    => $email,
    //                 'username' => $username,
    //                 'password' => $hashedPassword,
    //                 'active'   => 1,
    //             ]);
    //         }

    //         helper('auth');
    //         $auth = service('authentication');

    //         // Login menggunakan email dan password tetap
    //         $auth->attempt([
    //             'email'    => $email,
    //             'password' => $defaultGooglePassword
    //         ], false);

    //         // $auth->attempt([
    //         //     'email'    => $email,
    //         //     'password' => $defaultPassword,
    //         // ]);

    //         // $userModel = new UserModel();
    //         // $user = $userModel->where('email', $email)->first();

    //         // if (!$user) {
    //         //     $userModel->insert([
    //         //         'email' => $email,
    //         //         'username' => $username,
    //         //         'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
    //         //         'active' => 1,
    //         //     ]);
    //         //     $user = $userModel->where('email', $email)->first();
    //         // }

    //         // helper('auth');

    //         // $auth = service('authentication');
    //         // $auth->login($user);

    //         return redirect()->to('/');
    //     }

    //     return redirect()->to('/login');
    // }
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

        // Login langsung setelah register
        helper('auth');
        $auth = service('authentication');
        $auth->attempt([
            'email' => $oauthData['email'],
            'password' => 'google_secret_password',
        ], false);

        return redirect()->to('/');
    }
}
