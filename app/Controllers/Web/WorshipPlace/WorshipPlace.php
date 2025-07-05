<?php

namespace App\Controllers\Web\WorshipPlace;

use App\Controllers\BaseController;
use App\Database\Migrations\WorshipPlaceCategory;
// use App\Models\GalleryWorshipPlaceModel;
// use App\Models\ReviewModel;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;

use App\Models\Worship\WorshipPlaceModel;
use App\Models\Worship\WorshipPlaceGalleryModel;
use App\Models\Worship\WorshipPlaceCategoryModel;
use App\Models\Worship\WorshipPlaceFacilityModel;
use App\Models\Worship\WorshipPlaceFacilityDetailModel;
use App\Models\VillageModel;

class WorshipPlace extends BaseController
{
    use ResponseTrait;

    protected $worshipPlaceModel;
    protected $worshipPlaceGalleryModel;
    protected $worshipPlaceCategoryModel;
    protected $galleryWorshipPlaceModel;
    protected $reviewModel;
    protected $villageModel;
    protected $worshipPlaceFacilityModel;
    protected $worshipPlaceFacilityDetailModel;

    public function __construct()
    {
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->worshipPlaceCategoryModel = new WorshipPlaceCategoryModel();
        $this->worshipPlaceGalleryModel = new WorshipPlaceGalleryModel();
        $this->villageModel = new VillageModel();
        $this->worshipPlaceFacilityModel = new WorshipPlaceFacilityModel();
        $this->worshipPlaceFacilityDetailModel = new WorshipPlaceFacilityDetailModel();
        // // $this->galleryWorshipPlaceModel = new GalleryWorshipPlaceModel();
        // $this->reviewModel = new ReviewModel();
    }
    public function index()
    {
        $contents = $this->worshipPlaceModel->get_list_wp_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Worship Place"
            ]
        ];
        return $this->respond($response);
    }
    public function show($id = null)
    {
        $worshipPlace = $this->worshipPlaceModel->get_wp_by_id_api($id)->getRowArray();
        if (empty($worshipPlace)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        $list_facility = $this->worshipPlaceFacilityDetailModel->get_facility_by_wp_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }

        $list_gallery = $this->worshipPlaceGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $worshipPlace['facilities'] = $facilities;
        $worshipPlace['gallery'] = $galleries;

        $data = [
            'title' => $worshipPlace['name'],
            'data' => $worshipPlace,
        ];

        $data['data']['geoJson'] = [
            'type' => 'Feature',
            'geometry' => json_decode($data['data']['geoJson']),
            'properties' => []
        ];

        if (url_is('*dashboard*')) {
            return view('admin/worship_place_detail', $data);
        }
        return view('web/worship_place_detail', $data);
    }
    public function new()
    {
        $facilities = $this->worshipPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $categories = $this->worshipPlaceCategoryModel->get_list_wscat_api()->getResultArray();
        $data = [
            'title' => 'New Worship Place',
            'categories' => $categories,
            'facilities' => $facilities,
        ];
        return view('admin/worship_place_form', $data);
    }
    public function create()
    {
        $request = $this->request->getPost();
        $id = $this->worshipPlaceModel->get_new_id_api();
        $village = $this->villageModel->check_village()->getRowArray();
        $requestData = [
            'id' => $id,
            'village_id' => $village['id'],
            'name' => $request['name'],
            'worship_place_category' => $request['worship_place_category'],
            'address' => $request['address'],
            'capacity' => $request['capacity'],
            'description' => $request['description'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $geojson = $request['geo-json'];

        $addWP = $this->worshipPlaceModel->add_wp_api($requestData, $geojson);

        $addFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $addFacilities = $this->worshipPlaceFacilityDetailModel->add_facility_api($id, $facilities);
        } 

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
            $this->worshipPlaceGalleryModel->add_gallery_api($id, $gallery);
        }

        if ($addWP) {
            return redirect()->to(base_url('dashboard/worshipPlace') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function edit($id = null)
    {
        $facilities = $this->worshipPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $worshipPlace = $this->worshipPlaceModel->get_wp_by_id_api($id)->getRowArray();
        if (empty($worshipPlace)) {
            return redirect()->to('dashboard/worshipPlace');
        }

        $list_facility = $this->worshipPlaceFacilityDetailModel->get_facility_by_wp_api($id)->getResultArray();
        $selectedFac = array();
        foreach ($list_facility as $facility) {
            $selectedFac[] = $facility['name'];
        }

        $list_gallery = $this->worshipPlaceGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $worshipPlace['facilities'] = $selectedFac;
        $worshipPlace['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Worship Place',
            'data' => $worshipPlace,
            'facilities' => $facilities,
        ];
        return view('admin/worship_place_form', $data);
    }
    public function update($id = null)
    {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'worship_place_category' => $request['worship_place_category'],
            'address' => $request['address'],
            'capacity' => $request['capacity'],
            'description' => $request['description'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];
        $updateWP = $this->worshipPlaceModel->update_wp_api($id, $requestData, $geojson);

        $updateFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $updateFacilities = $this->worshipPlaceFacilityDetailModel->update_facility_api($id, $facilities);
        }

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
            $this->worshipPlaceGalleryModel->update_gallery_api($id, $gallery);
        } else {
            $this->worshipPlaceGalleryModel->delete_gallery_api($id);
        }

        if ($updateWP) {
            return redirect()->to(base_url('dashboard/worshipPlace') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function facilityWorshipPlace()
    {
        $contents = $this->worshipPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'Manage Worship Place Facility',
            'category' => 'Worship Place Facility',
            'data' => $contents,
        ];
        return view('admin/manage_admin', $data);
    }
    public function addNewFacilityWorshipPlace()
    {
        $request = $this->request->getPost();

        $requestData = [
            'name' => $request['name'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->worshipPlaceFacilityModel->add_wpf_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/facilityWorshipPlace'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editFacilityWorshipPlace($id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'id' => $id,
            'name' => $request['name'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $editSV = $this->worshipPlaceFacilityModel->edit_wpf_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/facilityWorshipPlace'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteFacilityWorshipPlace($id = null)
    {
        $deleteS = $this->worshipPlaceFacilityModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Worship Place Facility"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Worship Place Facility not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
