<?php

namespace App\Controllers\Api;

use App\Models\GalleryWorshipPlaceModel;
use App\Models\ReviewModel;
use App\Models\WorshipPlaceModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use App\Models\WorshipPlaceCategoryModel;

use App\Models\ServiceProviderModel;
use App\Models\ServiceProviderGalleryModel;


class ServiceProvider extends ResourceController
{
    use ResponseTrait;

    protected $worshipPlaceModel;
    protected $galleryWorshipPlaceModel;
    protected $reviewModel;

    protected $worshipPlaceCategoryModel;

    protected $serviceProviderModel;
    protected $serviceProviderGalleryModel;

    public function __construct()
    {
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->galleryWorshipPlaceModel = new GalleryWorshipPlaceModel();
        $this->reviewModel = new ReviewModel();

        $this->worshipPlaceCategoryModel = new WorshipPlaceCategoryModel();

        $this->serviceProviderModel = new ServiceProviderModel();
        $this->serviceProviderGalleryModel = new ServiceProviderGalleryModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->serviceProviderModel->get_list_sv_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Service Provider"
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $service_provider = $this->serviceProviderModel->get_sv_by_id_api($id)->getRowArray();

        $list_gallery = $this->serviceProviderGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $service_provider['gallery'] = $galleries;

        $response = [
            'data' => $service_provider,
            'status' => 200,
            'message' => [
                "Success display detail information of Service Provider"
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $request = $this->request->getJSON(true);
        $id = $this->worshipPlaceModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'park_area_size' => $request['park_area_size'],
            'building_size' => $request['building_size'],
            'capacity' => $request['capacity'],
            'last_renovation' => $request['last_renovation'],
            'geom' => $request['geom'],
            'category_id' => $request['category_id'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addWP = $this->worshipPlaceModel->add_wp_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilityWorshipPlaceModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryWorshipPlaceModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoWorshipPlaceModel->add_video_api($id, array($video));
        if ($addWP && $addFacilities && $addGallery && $addVideo) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Worship Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Worship Place",
                    "Add Worship Place: {$addWP}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
                ]
            ];
            return $this->respond($response, 400);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $request = $this->request->getJSON(true);
        $requestData = [
            'name' => $request['name'],
            'address' => $request['address'],
            'park_area_size' => $request['park_area_size'],
            'building_size' => $request['building_size'],
            'capacity' => $request['capacity'],
            'last_renovation' => $request['last_renovation'],
            'geom' => $request['geom'],
            'category_id' => $request['category_id'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateWP = $this->worshipPlaceModel->update_wp_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilityWorshipPlaceModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryWorshipPlaceModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoWorshipPlaceModel->update_video_api($id, array($video));
        if ($updateWP && $updateFacilities && $updateGallery && $updateVideo) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Worship Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Worship Place",
                    "Update Worship Place: {$updateWP}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                ]
            ];
            return $this->respond($response, 400);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $deleteSV = $this->serviceProviderModel->delete(['id' => $id]);
        if ($deleteSV) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Service Provider"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Service Provider not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function findByRadius()
    {
        $request = $this->request->getPost();
        $contents = $this->worshipPlaceModel->get_wp_by_radius_api($request)->getResult();
        $contents = $this->serviceProviderModel->get_sv_by_radius_api($request)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Service Provider by radius"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->worshipPlaceModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Worship Place"
            ]
        ];
        return $this->respond($response);
    }

    public function getWPCat()
    {
        $contents = $this->worshipPlaceCategoryModel->get_list_wscat_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Owner"
            ]
        ];
        return $this->respond($response);
    }
}
