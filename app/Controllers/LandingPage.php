<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use App\Controllers\BaseController;
use App\Models\VillageModel;
use App\Models\VillageGalleryModel;
use Myth\Auth\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class LandingPage extends BaseController
{
    use ResponseTrait;
    protected $villageModel;
    protected $villageGalleryModel;
    protected $userModel;
    public function __construct()
    {
        $this->villageModel = new VillageModel();
        $this->villageGalleryModel = new VillageGalleryModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $checkVillage = $this->villageModel->check_village()->getRowArray();
        $data = [
            'village' => $checkVillage
        ];

        if ($checkVillage) {

            $user_phone = $this->userModel->get_admin_phone()->getRowArray();
            $data['village']['phone'] = $user_phone['phone'];

            $list_gallery = $this->villageGalleryModel->get_gallery_api($checkVillage['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $data['gallery'] = $galleries;
        }

        return view('landing_page', $data);
    }

    public function mail()
    {
        ini_set('max_execution_time', 120);
        $email = \Config\Services::email();
        $email->clear();

        $email->setTo('nightbaron.369@gmail.com'); // Ganti dengan email penerima
        $email->setSubject('Tes Email dari CodeIgniter 4');
        $email->setMessage('<h1>Halo!</h1><p>Ini adalah pesan uji coba.</p>');

        if ($email->send()) {
            echo 'Email berhasil dikirim.';
        } else {
            echo 'Gagal mengirim email.<br>';
            echo $email->printDebugger(['headers', 'subject', 'body']);
        }
    }

    public function addVillage()
    {
        $data = [
            'title' => 'New Village',
            // 'facilities' => $facilities,
        ];
        return view('dashboard/village_form', $data);
    }
    public function addVillageNew()
    {
        $request = $this->request->getPost();
        $request['district'] = 'Kabupaten Lima Puluh Kota';
        $requestData = [
            'id' => $request['id'],
            'name' => $request['name'],
            'district' => $request['district'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];

        $addHS = $this->villageModel->add_village($requestData, $geojson);


        if ($addHS) {
            $data = [
                'title' => 'New Village',
                // 'facilities' => $facilities,
            ];
            return view('dashboard/village_form', $data);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function getKabKotaData()
    {

        $vilProperty = $this->villageModel->get_kab_kota()->getRowArray();
        $village = 'K11';
        $geoJson = json_decode($this->villageModel->get_geoJson_api_zzz($village)->getRowArray()['geoJson']);
        $content = [
            'type' => 'Feature',
            'geometry' => $geoJson,
            'properties' => [
                'id' => $vilProperty['id'],
                'name' => $vilProperty['name'],
            ]
        ];
        $response = [
            'data' => $content,
            'status' => 200,
            'message' => [
                "Success display data of Sumpur "
            ]
        ];
        return $this->respond($response);
    }
    public function setup()
    {
        $data = [
            'title' => 'App Set Up',
        ];

        return view('admin/setup/setup', $data);
    }

    public function selectVillage()
    {
        $request = $this->request->getPost();

        $requestData = [
            'selected' => '1',
            'address' => $request['address'],
            'description' => $request['description'],
            'ticket_price' => $request['ticket_price'],
            'open' => $request['open'],
            'close' => $request['close'],
            'email' => ($request['email'] == "") ? null : $request['email'],
            'facebook' => ($request['facebook'] == "") ? null : $request['facebook'],
            'instagram' => ($request['instagram'] == "") ? null : $request['instagram'],
            'youtube' => ($request['youtube'] == "") ? null : $request['youtube'],
            'tiktok' => ($request['tiktok'] == "") ? null : $request['tiktok'],
        ];

        if (isset($request['video'])) {
            $folder = $request['video'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $vidFile = new File($filepath . '/' . $filenames[0]);
            $vidFile->move(FCPATH . 'media/videos');
            delete_files($filepath);
            rmdir($filepath);
            $requestData['video_url'] = $vidFile->getFilename();
        }

        $update = $this->villageModel->update_village($request['id_village'], $requestData);

        if (isset($request['gallery'])) {
            $folders = $request['gallery'];
            $gallery = array();
            foreach ($folders as $folder) {
                $filepath = WRITEPATH . 'uploads/' . $folder;
                $filenames = get_filenames($filepath);
                $fileImg = new File($filepath . '/' . $filenames[0]);
                $fileImg->move(FCPATH . 'media/photos');
                delete_files($filepath);
                rmdir($filepath);
                $gallery[] = $fileImg->getFilename();
            }
            $this->villageGalleryModel->add_gallery_api($request['id_village'], $gallery);
        }

        if ($update) {
            return redirect()->to(base_url('dashboard') . '/');
        } else {
            return redirect()->back()->withInput();
        }
        // dd($update);
    }
}
