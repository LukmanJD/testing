<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\TouristAreaModel;
use App\Models\VillageModel;
use App\Models\VillageGalleryModel;
use Myth\Auth\Models\UserModel;
use App\Models\Homestay\HomestayModel;
use App\Models\Culinary\CulinaryPlaceModel;
use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\Worship\WorshipPlaceModel;

class TouristArea extends ResourcePresenter
{

    use ResponseTrait;

    protected $touristAreaModel;
    protected $villageModel;
    protected $villageGalleryModel;
    protected $userModel;
    protected $homestayModel;
    protected $culinaryPlaceModel;
    protected $worshipPlaceModel;
    protected $souvenirPlaceModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->touristAreaModel = new TouristAreaModel();
        $this->villageModel = new VillageModel();
        $this->villageGalleryModel = new VillageGalleryModel();
        $this->userModel = new UserModel();
        $this->homestayModel = new HomestayModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
    }

    public function index()
    {
        // $("#result-explore-col").hide();
        $village = $this->villageModel->check_village()->getRowArray();
        $user_phone = $this->userModel->get_admin_phone()->getRowArray();
        $village['phone'] = $user_phone['phone'];
        $contents3 = $this->villageModel->get_announcement_info()->getResultArray();


        $list_gallery = $this->villageGalleryModel->get_gallery_api($village['id'])->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
        $village['gallery'] = $galleries;
        $village['id_ta'] = $village['id'];
        unset($village['id']);

        $data = [
            'title' => 'Home',
            'data' => $village,
            'data3' => $contents3,
        ];

        return view('home/home', $data);
    }

    public function addTouristArea()
    {
        $request = $this->request->getPost();
        $request['id'] = 'L1';
        $requestData = [
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];

        $addHS = $this->touristAreaModel->add_tourist_area($requestData, $geojson);

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

    public function allObject()
    {
        $data = array();
        $homestay = $this->homestayModel->get_list_hs_api()->getResultArray();
        for ($i = 0; $i < count($homestay); $i++) {
            $data[] = $homestay[$i];
        }
        $culinary = $this->culinaryPlaceModel->get_list_cp_api()->getResultArray();
        for ($i = 0; $i < count($culinary); $i++) {
            $data[] = $culinary[$i];
        }
        $souvenir = $this->souvenirPlaceModel->get_list_sp_api()->getResultArray();
        for ($i = 0; $i < count($souvenir); $i++) {
            $data[] = $souvenir[$i];
        }
        $worship = $this->worshipPlaceModel->get_list_wp_api()->getResultArray();
        for ($i = 0; $i < count($worship); $i++) {
            $data[] = $worship[$i];
        }

        $response = [
            'data' => $data,
            'status' => 200,
            'message' => [
                "Success get list of facility"
            ]
        ];
        return $this->respond($response);
    }

    public function aroundYou()
    {
      $data = [
            'title' => 'Around You',
        ];

        return view('around_you', $data);
    }
}
