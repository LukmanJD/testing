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
        $this->client->setClientId(env('google.clientId')); // Get from .env file
        $this->client->setClientSecret(env('google.clientSecret')); // Get from .env file
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
<<<<<<< Updated upstream
=======

                $this->client->setAccessToken($token);

                $googleUser = (object) $payload;

                $user = $this->findOrCreateUser($googleUser);

                // Log the user in
                $auth = service('authentication');
                $auth->login($user);

                return redirect()->to('/web')->with('message', lang('Auth.loginSuccess'));
            } catch (\Exception $e) {
                log_message('error', '[AuthGoogle] ' . $e->getMessage());
                return redirect()->to('/login')->with('error', 'Failed to authenticate with Google: ' . $e->getMessage());
>>>>>>> Stashed changes
            }

            $auth = service('authentication');
            // Directly log in the user by their ID
            $auth->loginById($user->id);

            return redirect()->to('/');
        }

        return redirect()->to('/login');
    }
<<<<<<< Updated upstream
=======

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

            // Download and save avatar
            $imageData = $this->_downloadGoogleAvatar($googleUser->picture);
            $avatarFilename = null;
            if ($imageData) {
                $avatarFilename = $this->_saveAvatar($imageData, $googleUser->email);
            }

            $user = new User([
                'email'    => $googleUser->email,
                'username' => $username,
                'password' => $password,
                'avatar'   => $avatarFilename,
                'active'   => 1, // Activate account immediately
            ]);

            // Use withGroup() to add to the 'user' group on save.
            if ($userModel->withGroup('user')->save($user) === false) {
                log_message('error', 'Failed to save Google user: ' . json_encode($userModel->errors()));
                throw new \RuntimeException(lang('Auth.registerFailure'));
            }

            return $userModel->find($userModel->getInsertID());
        }

        // User exists, check if avatar has changed
        $imageData = $this->_downloadGoogleAvatar($googleUser->picture);

        if ($imageData) {
            $isDifferent = true;
            // Check against existing local avatar
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                $currentPath = FCPATH . 'media/photos/' . $user->avatar;
                if (file_exists($currentPath)) {
                    $currentData = file_get_contents($currentPath);
                    if ($currentData === $imageData) {
                        $isDifferent = false;
                    }
                }
            }

            if ($isDifferent) {
                $newFilename = $this->_saveAvatar($imageData, $googleUser->email);
                if ($newFilename) {
                    // Delete old avatar
                    if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                        $oldAvatarPath = FCPATH . 'media/photos/' . $user->avatar;
                        if (file_exists($oldAvatarPath)) {
                            unlink($oldAvatarPath);
                        }
                    }
                    $userModel->update($user->id, ['avatar' => $newFilename]);
                    $user = $userModel->find($user->id);
                }
            }
        }

        return $user;
    }

    /**
     * Downloads a Google profile picture data.
     *
     * @param string $url The URL of the Google profile picture.
     * @return string|null The image data on success, or null on failure.
     */
    private function _downloadGoogleAvatar(string $url): ?string
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

            return $imageData;
        } catch (\Exception $e) {
            log_message('error', '[AuthGoogle] Exception while downloading avatar: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Saves image data to disk.
     *
     * @param string $imageData The binary image data.
     * @param string $email The user's email for filename generation.
     * @return string|null The new filename on success, or null on failure.
     */
    private function _saveAvatar(string $imageData, string $email): ?string
    {
        // Create a unique filename based on the user's email and current time to avoid caching issues.
        $newFilename = sha1($email . time()) . '.jpg';
        $path = FCPATH . 'media/photos/' . $newFilename;

        return file_put_contents($path, $imageData) ? $newFilename : null;
    }
>>>>>>> Stashed changes
}
