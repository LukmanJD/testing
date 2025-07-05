<?php

namespace App\Controllers\Api;

use App\Models\GallerySouvenirPlaceModel;
use App\Models\ReviewModel;
use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\Souvenir\SouvenirProductModel;
use App\Models\Souvenir\SouvenirProductDetailModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use App\Models\VillageModel;

class SouvenirPlace extends ResourceController
{
    use ResponseTrait;

    protected $souvenirPlaceModel;
    protected $souvenirProductModel;
    protected $souvenirProductDetailModel;
    protected $gallerySouvenirPlaceModel;
    protected $reviewModel;
    protected $villageModel;

    public function __construct()
    {
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->souvenirProductModel = new SouvenirProductModel();
        $this->souvenirProductDetailModel = new SouvenirProductDetailModel();
        $this->gallerySouvenirPlaceModel = new GallerySouvenirPlaceModel();
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

        $contents = $this->souvenirPlaceModel->get_list_sp_by_vil_api($village['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Souvenir Place"
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
        $souvenir_place = $this->souvenirPlaceModel->get_sp_by_id_api($id)->getRowArray();

        $list_gallery = $this->gallerySouvenirPlaceModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $souvenir_place['gallery'] = $galleries;

        $response = [
            'data' => $souvenir_place,
            'status' => 200,
            'message' => [
                "Success display detail information of Souvenir Place"
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
        $id = $this->souvenirPlaceModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'contact_person' => $request['contact_person'],
            'owner' => $request['owner'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'open' => $request['open'],
            'close' => $request['close'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addSP = $this->souvenirPlaceModel->add_sp_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilitySouvenirPlaceModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->gallerySouvenirPlaceModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoSouvenirPlaceModel->add_video_api($id, array($video));
        $products = $request['products'];
        $addProduct = $this->detailProductModel->add_product_api($id, $products);
        if ($addSP && $addFacilities && $addGallery && $addVideo && $addProduct) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Souvenir Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Souvenir Place",
                    "Add Souvenir Place: {$addSP}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
                    "Add Product: {$addProduct}",
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
            'owner' => $request['owner'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'open' => $request['open'],
            'close' => $request['close'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateSP = $this->souvenirPlaceModel->update_sp_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilitySouvenirPlaceModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->gallerySouvenirPlaceModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoSouvenirPlaceModel->update_video_api($id, array($video));
        $products = $request['products'];
        $updateProduct = $this->detailProductModel->update_product_api($id, $products);
        if ($updateSP && $updateFacilities && $updateGallery && $updateVideo && $updateProduct) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Souvenir Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Souvenir Place",
                    "Update Souvenir Place: {$updateSP}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                    "Update Product: {$updateProduct}",
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
        $deleteSP = $this->souvenirPlaceModel->delete(['id' => $id]);
        if ($deleteSP) {
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

        $contents = $this->souvenirPlaceModel->get_list_sp_api()->getResultArray();

        $i = 0;
        foreach ($contents as $content) {

            $isWithinRadius = $this->isWithinRadius($request['lat'], $request['long'], $content['lat'], $content['lng'], (int)$request['radius'] / 1000);
            if (!$isWithinRadius) {
                unset($contents[$i]);
            }
            $i++;
        }
        // $contents = $this->souvenirPlaceModel->get_sp_by_radius_api($request)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Souvenir Place by radius"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->souvenirPlaceModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Souvenir Place"
            ]
        ];
        return $this->respond($response);
    }
    public function proList($souvenir_place_id = null)
    {
        $id_prod_owned = $this->souvenirProductDetailModel->get_product_id_by_sp_api($souvenir_place_id)->getResultArray();
        $newData = array();
        foreach ($id_prod_owned as $row) {
            $newData[] = $row['souvenir_product_id'];
        }
        $id_prod_owned = $newData;
        if (empty($id_prod_owned)) {
            $contents = $this->souvenirProductModel->get_list_spr_api()->getResult();
        } else {
            $contents = $this->souvenirProductModel->get_list_spr_not_owned_api($id_prod_owned)->getResult();
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
        $contents = $this->souvenirPlaceModel->get_list_sp_api()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find all suovenir place"
            ]
        ];
        return $this->respond($response);
    }
}
