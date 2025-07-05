<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Database\Migrations\WorshipPlaceCategory;
use App\Models\GalleryWorshipPlaceModel;
use App\Models\ReviewModel;
use App\Models\WorshipPlaceModel;
use App\Models\WorshipPlaceGalleryModel;
use App\Models\WorshipPlaceCategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;

use App\Models\ServiceModel;
use App\Models\ServiceProviderModel;
use App\Models\ServiceProviderGalleryModel;

class ServiceProvider extends BaseController
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

    public function __construct()
    {
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->worshipPlaceCategoryModel = new WorshipPlaceCategoryModel();
        $this->worshipPlaceGalleryModel = new WorshipPlaceGalleryModel();
        $this->galleryWorshipPlaceModel = new GalleryWorshipPlaceModel();
        $this->reviewModel = new ReviewModel();

        $this->serviceModel = new ServiceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->serviceProviderGalleryModel = new ServiceProviderGalleryModel();
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
        $serviceProvider = $this->serviceProviderModel->get_sv_by_id_api($id)->getRowArray();
        if (empty($serviceProvider)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        $list_service = $this->serviceModel->get_service_by_sv_api($id)->getResultArray();

        // $services = array();
        // foreach ($list_service as $service) {
        //     $services = $service;
        // }
        // dd($list_service);

        $list_gallery = $this->serviceProviderGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $serviceProvider['gallery'] = $galleries;
        $data = [
            'title' => $serviceProvider['name'],
            'data' => $serviceProvider,
            'services' => $list_service,
        ];

        $data['data']['geoJson'] = [
            'type' => 'Feature',
            'geometry' => json_decode($data['data']['geoJson']),
            'properties' => []
        ];

        if (url_is('*dashboard*')) {
            return view('dashboard/service_provider_detail', $data);
        }
        return view('web/service_provider_detail', $data);
    }
    public function new()
    {
        $data = [
            'title' => 'New Service Provider',
        ];
        return view('dashboard/service_provider_form', $data);
    }
    public function create()
    {
        $request = $this->request->getPost();
        $id = $this->serviceProviderModel->get_new_id_api();
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

        $geojson = $request['geo-json'];

        $addSV = $this->serviceProviderModel->add_sv_api($requestData, $geojson);

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
            $this->serviceProviderGalleryModel->add_gallery_api($id, $gallery);
        }

        if ($addSV) {
            return redirect()->to(base_url('dashboard/serviceProvider') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function edit($id = null)
    {
        $serviceProvider = $this->serviceProviderModel->get_sv_by_id_api($id)->getRowArray();
        if (empty($serviceProvider)) {
            return redirect()->to('dashboard/serviceProvider');
        }

        $list_gallery = $this->serviceProviderGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $serviceProvider['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Service Provider',
            'data' => $serviceProvider,
        ];
        return view('dashboard/service_provider_form', $data);
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
        $geojson = $request['geo-json'];
        $updateSV = $this->serviceProviderModel->update_sv_api($id, $requestData, $geojson);
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
            $this->serviceProviderGalleryModel->update_gallery_api($id, $gallery);
        } else {
            $this->serviceProviderGalleryModel->delete_gallery_api($id);
        }

        if ($updateSV) {
            return redirect()->to(base_url('dashboard/serviceProvider') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function addService()
    {
        $request = $this->request->getPost();

        $requestData = [
            'service_provider_id' => $request['service_provider_id'],
            'name' => $request['name'],
            'price' => $request['price'],
            'unit_price' => $request['unit_price'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->serviceModel->add_sv_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/serviceProvider') . '/' . $requestData['service_provider_id']);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editService($id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'price' => $request['price'],
            'unit_price' => $request['unit_price'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $editSV = $this->serviceModel->edit_sv_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/serviceProvider') . '/' . $request['service_provider_id']);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteService($id = null)
    {
        $deleteS = $this->serviceModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Service"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Service not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
