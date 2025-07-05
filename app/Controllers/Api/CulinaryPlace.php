<?php

namespace App\Controllers\Api;

use App\Models\Culinary\CulinaryPlaceModel;
use App\Models\Culinary\CulinaryPlaceGalleryModel;
use App\Models\Culinary\CulinaryProductModel;
use App\Models\Culinary\CulinaryProductDetailModel;
use App\Models\GalleryCulinaryPlaceModel;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use App\Models\VillageModel;

class CulinaryPlace extends ResourceController
{
    use ResponseTrait;

    protected $culinaryPlaceModel;
    protected $culinaryPlaceGalleryModel;
    protected $culinaryProductModel;
    protected $culinaryProductDetailModel;
    protected $galleryCulinaryPlaceModel;
    protected $reviewModel;

    protected $villageModel;

    public function __construct()
    {
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->culinaryPlaceGalleryModel = new CulinaryPlaceGalleryModel();
        $this->culinaryProductModel = new CulinaryProductModel();
        $this->culinaryProductDetailModel = new CulinaryProductDetailModel();
        $this->galleryCulinaryPlaceModel = new GalleryCulinaryPlaceModel();
        $this->reviewModel = new ReviewModel();

        $this->villageModel = new VillageModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $village = $this->villageModel->check_village()->getRowArray();
        $contents = $this->culinaryPlaceModel->get_list_cp_by_vil_api($village['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Culinary Place"
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
        $culinary_place = $this->culinaryPlaceModel->get_cp_by_id_api($id)->getRowArray();

        $list_gallery = $this->culinaryPlaceGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $culinary_place['gallery'] = $galleries;

        $response = [
            'data' => $culinary_place,
            'status' => 200,
            'message' => [
                "Success display detail information of Culinary Place"
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
        $id = $this->culinaryPlaceModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'contact_person' => $request['contact_person'],
            'capacity' => $request['capacity'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addCP = $this->culinaryPlaceModel->add_cp_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilityCulinaryPlaceModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryCulinaryPlaceModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoCulinaryPlaceModel->add_video_api($id, array($video));
        $menus = $request['menus'];
        $addMenu = $this->detailMenuModel->add_menu_api($id, $menus);
        if ($addCP && $addFacilities && $addGallery && $addVideo && $addMenu) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Culinary Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Culinary Place",
                    "Add Culinary Place: {$addCP}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
                    "Add Menu: {$addMenu}",
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
            'contact_person' => $request['contact_person'],
            'capacity' => $request['capacity'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateCP = $this->culinaryPlaceModel->update_cp_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilityCulinaryPlaceModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryCulinaryPlaceModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoCulinaryPlaceModel->update_video_api($id, array($video));
        $menus = $request['menus'];
        $updateMenu = $this->detailMenuModel->update_menu_api($id, $menus);
        if ($updateCP && $updateFacilities && $updateGallery && $updateVideo && $updateMenu) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Culinary Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Culinary Place",
                    "Update Culinary Place: {$updateCP}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                    "Update Menu: {$updateMenu}",
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
        $deleteCP = $this->culinaryPlaceModel->delete(['id' => $id]);
        if ($deleteCP) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Culinary Place"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Culinary Place not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function findByRadius()
    {
        $request = $this->request->getPost();

        $contents = $this->culinaryPlaceModel->get_list_cp_api()->getResultArray();

        $i = 0;
        foreach ($contents as $content) {

            $isWithinRadius = $this->isWithinRadius($request['lat'], $request['long'], $content['lat'], $content['lng'], (int)$request['radius'] / 1000);
            if (!$isWithinRadius) {
                unset($contents[$i]);
            }
            $i++;
        }
        // $contents = $this->culinaryPlaceModel->get_cp_by_radius_api($request)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Culinary Place by radius"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->culinaryPlaceModel->list_by_owner($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Culinary Place"
            ]
        ];
        return $this->respond($response);
    }
    public function culList($souvenir_place_id = null)
    {
        $id_prod_owned = $this->culinaryProductDetailModel->get_product_id_by_sp_api($souvenir_place_id)->getResultArray();
        $newData = array();
        foreach ($id_prod_owned as $row) {
            $newData[] = $row['culinary_product_id'];
        }
        $id_prod_owned = $newData;
        if (empty($id_prod_owned)) {
            $contents = $this->culinaryProductModel->get_list_cpr_api()->getResult();
        } else {
            $contents = $this->culinaryProductModel->get_list_cpr_not_owned_api($id_prod_owned)->getResult();
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Product"
            ]
        ];
        return $this->respond($response);
    }
    public function isWithinRadius($lat1, $lon1, $lat2, $lon2, $radius)
    {
        // Konstanta jari-jari bumi dalam kilometer
        $earthRadius = 6371;

        // Konversi derajat ke radian
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Menghitung perbedaan lintang dan bujur
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Menggunakan rumus Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Menghitung jarak
        $distance = $earthRadius * $c;

        // Memeriksa apakah jarak berada dalam radius
        return $distance <= $radius;
    }

    function findAll()
    {
        $contents = $this->culinaryPlaceModel->get_list_cp_api()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find all culinary place"
            ]
        ];
        return $this->respond($response);
    }
}
