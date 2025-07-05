<?php

namespace App\Controllers\Web\SouvenirPlace;

use App\Controllers\BaseController;
use App\Database\Migrations\WorshipPlaceCategory;
// use App\Models\GalleryWorshipPlaceModel;
// use App\Models\ReviewModel;
// use App\Models\WorshipPlaceModel;
// use App\Models\WorshipPlaceGalleryModel;
// use App\Models\WorshipPlaceCategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;

// use App\Models\ServiceModel;
// use App\Models\ServiceProviderModel;
// use App\Models\ServiceProviderGalleryModel;

use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\Souvenir\SouvenirPlaceGalleryModel;
use App\Models\Souvenir\SouvenirProductModel;
use App\Models\Souvenir\SouvenirProductDetailModel;
use App\Models\Souvenir\SouvenirPlaceFacilityModel;
use App\Models\Souvenir\SouvenirPlaceFacilityDetailModel;

use App\Models\VillageModel;

class SouvenirPlace extends BaseController
{
    use ResponseTrait;

    protected $worshipPlaceModel;
    protected $worshipPlaceGalleryModel;
    protected $worshipPlaceCategoryModel;
    protected $galleryWorshipPlaceModel;
    protected $reviewModel;

    protected $serviceModel;
    protected $serviceProviderModel;
    protected $serviceProviderGalleryModel;

    protected $souvenirPlaceModel;
    protected $souvenirPlaceGalleryModel;
    protected $souvenirProductModel;
    protected $souvenirProductDetailModel;
    protected $souvenirPlaceFacilityModel;
    protected $souvenirPlaceFacilityDetailModel;

    protected $villageModel;

    public function __construct()
    {
        // $this->worshipPlaceModel = new WorshipPlaceModel();
        // $this->worshipPlaceCategoryModel = new WorshipPlaceCategoryModel();
        // $this->worshipPlaceGalleryModel = new WorshipPlaceGalleryModel();
        // $this->galleryWorshipPlaceModel = new GalleryWorshipPlaceModel();
        // $this->reviewModel = new ReviewModel();

        // $this->serviceModel = new ServiceModel();
        // $this->serviceProviderModel = new ServiceProviderModel();
        // $this->serviceProviderGalleryModel = new ServiceProviderGalleryModel();

        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->souvenirPlaceGalleryModel = new SouvenirPlaceGalleryModel();
        $this->souvenirProductModel = new SouvenirProductModel();
        $this->souvenirProductDetailModel = new SouvenirProductDetailModel();
        $this->souvenirPlaceFacilityModel = new SouvenirPlaceFacilityModel();
        $this->souvenirPlaceFacilityDetailModel = new SouvenirPlaceFacilityDetailModel();
        $this->villageModel = new VillageModel();
    }
    public function index()
    {
        $contents = $this->serviceProviderModel->get_list_sv_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Service Privider"
            ]
        ];
        return $this->respond($response);
    }
    public function show($id = null)
    {
        $souvenirPlace = $this->souvenirPlaceModel->get_sp_by_id_api($id)->getRowArray();
        if (empty($souvenirPlace)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        $list_product = $this->souvenirProductDetailModel->get_product_by_sp_api($id)->getResultArray();

        $list_facility = $this->souvenirPlaceFacilityDetailModel->get_facility_by_sp_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }
    
        $list_gallery = $this->souvenirPlaceGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $souvenirPlace['facilities'] = $facilities;
        $souvenirPlace['gallery'] = $galleries;
        $data = [
            'title' => $souvenirPlace['name'],
            'data' => $souvenirPlace,
            'products' => $list_product,
        ];

        $data['data']['geoJson'] = [
            'type' => 'Feature',
            'geometry' => json_decode($data['data']['geoJson']),
            'properties' => []
        ];

        if (url_is('*dashboard*')) {
            return view('admin/souvenir_place_detail', $data);
        }
        return view('web/souvenir_place_detail', $data);
    }
    public function new()
    {
        $facilities = $this->souvenirPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'New Souvenir Place',
            'facilities' => $facilities,
        ];
        return view('admin/souvenir_place_form', $data);
    }
    public function create()
    {
        $request = $this->request->getPost();
        $id = $this->souvenirPlaceModel->get_new_id_api();
        $village = $this->villageModel->check_village()->getRowArray();
        $requestData = [
            'id' => $id,
            'village_id' => $village['id'],
            'name' => $request['name'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee_name' => $request['employee_name'],
            'phone' => $request['phone'],
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

        $addSP = $this->souvenirPlaceModel->add_sp_api($requestData, $geojson);

        $addFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $addFacilities = $this->souvenirPlaceFacilityDetailModel->add_facility_api($id, $facilities);
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
            $this->souvenirPlaceGalleryModel->add_gallery_api($id, $gallery);
        }

        if ($addSP) {
            return redirect()->to(base_url('dashboard/souvenirPlace') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function edit($id = null)
    {
        $facilities = $this->souvenirPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $souvenirPlace = $this->souvenirPlaceModel->get_sp_by_id_api($id)->getRowArray();
        if (empty($souvenirPlace)) {
            return redirect()->to('dashboard/souvenirPlace');
        }

        $list_facility = $this->souvenirPlaceFacilityDetailModel->get_facility_by_sp_api($id)->getResultArray();
        $selectedFac = array();
        foreach ($list_facility as $facility) {
            $selectedFac[] = $facility['name'];
        }

        $list_gallery = $this->souvenirPlaceGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $souvenirPlace['facilities'] = $selectedFac;
        $souvenirPlace['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Souvenir Place',
            'data' => $souvenirPlace,
            'facilities' => $facilities,
        ];
        return view('admin/souvenir_place_form', $data);
    }
    public function update($id = null)
    {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee_name' => $request['employee_name'],
            'phone' => $request['phone'],
            'description' => $request['description'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $updateFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $updateFacilities = $this->souvenirPlaceFacilityDetailModel->update_facility_api($id, $facilities);
        }

        $geojson = $request['geo-json'];
        $updateSV = $this->souvenirPlaceModel->update_sp_api($id, $requestData, $geojson);
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
            $this->souvenirPlaceGalleryModel->update_gallery_api($id, $gallery);
        } else {
            $this->souvenirPlaceGalleryModel->delete_gallery_api($id);
        }

        if ($updateSV) {
            return redirect()->to(base_url('dashboard/souvenirPlace') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function listProduct()
    {
        $contents = $this->souvenirProductModel->get_list_spr_api()->getResultArray();
        $data = [
            'title' => 'Manage Souvenir Product',
            'category' => 'Souvenir Product',
            'data' => $contents,
        ];
        return view('admin/manage_admin', $data);
    }

    public function addNewProduct()
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

        $addSV = $this->souvenirProductModel->add_spr_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/souvenirPlace/product'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editProduct($id = null)
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

        $editSV = $this->souvenirProductModel->edit_spr_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/souvenirPlace/product'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteProduct($id = null)
    {
        $deleteS = $this->souvenirProductModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Product"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Product not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    public function addProduct()
    {
        $request = $this->request->getPost();

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

        $requestData = [
            'souvenir_place_id' => $request['souvenir_place_id'],
            'souvenir_product_id' => $request['souvenir_product_id'],
            'price' => $request['price'],
            'image_url' => $gallery[0],
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->souvenirProductDetailModel->add_spr_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/souvenirPlace/' . $requestData['souvenir_place_id']));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editSouvenirProduct($souvenirPlaceId = null, $souvenirProductId = null)
    {
        $request = $this->request->getPost();

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

        $requestData = [
            'price' => $request['price'],
            'image_url' => $gallery[0],
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->souvenirProductDetailModel->update_spr_api($requestData, $souvenirPlaceId, $souvenirProductId);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/souvenirPlace/' . $souvenirPlaceId));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteSouvenirProduct($souvenirPlaceId = null, $souvenirProductId = null)
    {
        $deleteS = $this->souvenirProductDetailModel->delete_spr_by_id($souvenirPlaceId, $souvenirProductId);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Product"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Product not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function facilitySouvenirPlace()
    {
        $contents = $this->souvenirPlaceFacilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'Manage Souvenir Place Facility',
            'category' => 'Souvenir Place Facility',
            'data' => $contents,
        ];
        return view('admin/manage_admin', $data);
    }
    public function addNewFacilitySouvenirPlace()
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

        $addSV = $this->souvenirPlaceFacilityModel->add_spf_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/facilitySouvenirPlace'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editFacilitySouvenirPlace($id = null)
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

        $editSV = $this->souvenirPlaceFacilityModel->edit_spf_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/facilitySouvenirPlace'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteFacilitySouvenirPlace($id = null)
    {
        $deleteS = $this->souvenirPlaceFacilityModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Souvenir Place Facility"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "SouvenirPlace Facility not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
