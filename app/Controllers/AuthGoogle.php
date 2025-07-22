<?php

namespace App\Controllers;

use App\Entities\User;
use CodeIgniter\Controller;
use App\Models\UserModel; // Use your application's UserModel
use Google_Client;
use Myth\Auth\Authorization\GroupModel;
use Google_Service_Oauth2;

class AuthGoogle extends Controller
{
    protected $client;

    public function __construct()
    {
        helper('text');
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
        if ($code = service('request')->getGet('code')) {
            try {
                $token = $this->client->fetchAccessTokenWithAuthCode($code);
                $this->client->setAccessToken($token);

                $service = new Google_Service_Oauth2($this->client);
                $googleUser = $service->userinfo->get();

                $user = $this->findOrCreateUser($googleUser);

                // Log the user in
                $auth = service('authentication');
                $auth->login($user);

                return redirect()->to('/')->with('message', lang('Auth.loginSuccess'));
            } catch (\Exception $e) {
                log_message('error', '[AuthGoogle] ' . $e->getMessage());
                return redirect()->to('/login')->with('error', 'Failed to authenticate with Google.');
            }
        }

        return redirect()->to('/login');
    }

    /**
     * Finds an existing user or creates a new one.
     *
     * @param object $googleUser
     * @return User
     */
    private function findOrCreateUser(object $googleUser): User
    {
        // Use the model() helper to get the correct instance of UserModel
        $userModel = model(UserModel::class);

        $user = $userModel->where('email', $googleUser->email)->first();

        if (!$user) {
            // User doesn't exist, let's create a new one.
            $baseUsername = explode('@', $googleUser->email)[0];
            $username = $baseUsername;
            $i = 1;
            while ($userModel->where('username', $username)->first()) {
                $username = $baseUsername . $i++;
            }

            // Use a secure, random password for social logins.
            // Myth/Auth's UserModel will hash this automatically.
            $password = random_string('crypto', 32);

            $user = new User([
                'email'    => $googleUser->email,
                'username' => $username,
                'password' => $password,
                'avatar'   => $this->_storeGoogleAvatar($googleUser->picture, $googleUser->email), // Download and store avatar
                'active'   => 1, // Activate account immediately
            ]);

            // Use withGroup() to add to the 'user' group on save.
            if ($userModel->withGroup('user')->save($user) === false) {
                log_message('error', 'Failed to save Google user: ' . json_encode($userModel->errors()));
                throw new \RuntimeException(lang('Auth.registerFailure'));
            }

            return $userModel->find($userModel->getInsertID());
        }

        // User exists, update avatar if it has changed.
        // Download and store the new avatar locally.
        $localAvatar = $this->_storeGoogleAvatar($googleUser->picture, $googleUser->email);

        // Only update if the new avatar is different from the stored one.
        // This also handles the case where a new avatar couldn't be downloaded (localAvatar is null).
        if ($user->avatar !== $localAvatar) {
            // If the old avatar was a local file (not a URL and not default), delete it.
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $oldAvatarPath = FCPATH . 'media/photos/' . $user->avatar;
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $userModel->update($user->id, ['avatar' => $localAvatar]);
            // Reload user to get updated data
            $user = $userModel->find($user->id);
        }

        return $user;
    }

    /**
     * Downloads a Google profile picture and stores it locally.
     *
     * @param string $url The URL of the Google profile picture.
     * @return string|null The new filename on success, or null on failure.
     */
    private function _storeGoogleAvatar(string $url, string $email): ?string
    {
        try {
            // Use cURL for better error handling and to follow redirects.
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $imageData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($imageData === false || $httpCode >= 400 || empty($imageData) || getimagesizefromstring($imageData) === false) {
                log_message('error', '[AuthGoogle] Failed to download or validate avatar from: ' . $url);
                return null;
            }

            // Create a unique filename based on the user's email and current time to avoid caching issues.
            $newFilename = sha1($email . time()) . '.jpg';
            $path = FCPATH . 'media/photos/' . $newFilename;

            return file_put_contents($path, $imageData) ? $newFilename : null;
        } catch (\Exception $e) {
            log_message('error', '[AuthGoogle] Exception while downloading avatar: ' . $e->getMessage());
            return null;
        }
    }
}
