<?php

namespace App\Controllers\Web\Profile;

use App\Controllers\BaseController;
use App\Models\VillageModel;
use App\Models\AccountModel;
use App\Models\Reservation\ReservationModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;
use App\Models\Reservation\ReservationHomestayUnitDetailBackUpModel;
use App\Models\Homestay\HomestayModel;
use App\Models\VisitHistoryModel;
use CodeIgniter\Session\Session;
use CodeIgniter\Files\File;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Profile extends BaseController
{
    protected $villageModel;
    protected $accountModel;
    protected $reservationModel;
    protected $visitHistoryModel;
    protected $auth;
    protected $reservationHomestayUnitDetailModel;
    protected $homestayModel;
    protected $reservationHomestayUnitDetailBackUpModel;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;

    public function __construct()
    {
        $this->villageModel = new VillageModel();
        $this->accountModel = new AccountModel();
        $this->reservationModel = new ReservationModel();
        $this->visitHistoryModel = new VisitHistoryModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
        $this->homestayModel = new HomestayModel();
        $this->reservationHomestayUnitDetailBackUpModel = new ReservationHomestayUnitDetailBackUpModel();

        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    public function login()
    {

        $checkVillage = $this->villageModel->check_village()->getRowArray();
        $data = [
            'title' => 'Login',
            'village' => $checkVillage,
            'config' => $this->config,
        ];
        return view('auth/login', $data);
    }

    public function register()
    {
        $checkVillage = $this->villageModel->check_village()->getRowArray();

        $data = [
            'title' => 'Register',
            'village' => $checkVillage,
            'config' => $this->config,
        ];
        return view('auth/register', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'My Profile',
            'datas' => [],
        ];
        return view('profile/manage_profile', $data);
    }
    public function updateProfile()
    {
        $data = [
            'title' => 'My Profile',
            'errors' => [],
        ];
        return view('profile/update_profile', $data);
    }

    public function changePassword()
    {
        $data = [
            'title' => 'Change Password',
            'errors' => [],
            'success' => false
        ];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'password'     => 'required|strong_password',
                'pass_confirm' => 'required|matches[password]',
            ];

            if (! $this->validate($rules)) {
                $data['errors'] = $this->validator->getErrors();
                return view('profile/change_password', $data);
            }

            $requestData = [
                'password_hash' => Password::hash($this->request->getPost()['password']),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $query = $this->accountModel->change_password_user(user()->id, $requestData);
            if ($query) {
                $data['errors'] = ['Password is changed'];
                $data['success'] = true;
                return view('profile/change_password', $data);
            }
            $data['errors'] = ['Failed change password'];
            return view('profile/change_password', $data);
        }
        return view('profile/change_password', $data);
    }

    public function update()
    {
        $request = $this->request->getPost();
        $requestData = [
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        // Get the current user's raw avatar filename to check for an old avatar
        $oldAvatar = user()->attributes['avatar'] ?? null;

        if (($request['avatar']) != 'default.jpg') {
            $folder = $request['avatar'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            if (!empty($filenames)) {
                $avatar = new File($filepath . '/' . $filenames[0]);
                $avatar->move(FCPATH . 'media/photos');
                $requestData['avatar'] = $avatar->getFilename();

                // If the old avatar was not the default and not a URL, delete the old one.
                if ($oldAvatar && $oldAvatar !== 'default.jpg' && !filter_var($oldAvatar, FILTER_VALIDATE_URL)) {
                    // Use @ to suppress errors if the file doesn't exist
                    @unlink(FCPATH . 'media/photos/' . $oldAvatar);
                }

                delete_files($filepath);
                rmdir($filepath);
            }
        } else {
            $requestData['avatar'] = 'default.jpg';
        }

        $query = $this->accountModel->update_account_users(user()->id, $requestData);
        if ($query) {
            return redirect()->to('web/profile');
        }
        $data = [
            'title' => 'Update Profile',
            'errors' => ['Error update. ' . $query]
        ];
        return view('profile/update_profile', $data);
    }

    public function coinHistory()
    {
        $coin_use = $this->reservationModel->get_coin_use_history_by_user_id(user()->id)->getResultArray();
        // dd($coin_use);
        $i = 0;
        foreach ($coin_use as $coin) {
            if (($coin['canceled_at'] == null) && (($coin['is_rejected'] == '0') || ($coin['is_rejected'] == null))) {
                $id = $this->reservationHomestayUnitDetailModel->get_hs_by_id($coin['id'])->getRowArray();
            } else {
                $id = $this->reservationHomestayUnitDetailBackUpModel->get_hs_by_id($coin['id'])->getRowArray();
            }
            // dd($id);
            $homestay = $this->homestayModel->get_hs_by_id_api($id['homestay_id'])->getRowArray();
            // dd($homestay);
            $coin_use[$i]['homestay_name'] = $homestay['name'];
            $i++;
        }
        $data = [
            'title' => 'Coin History',
            'data' => $coin_use,
        ];

        return view('profile/coin_history', $data);
    }
}
