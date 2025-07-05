<?php

namespace App\Controllers\Api;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use App\Models\Homestay\HomestayModel;
use App\Models\AttractionModel;
use App\Models\AttractionGalleryModel;
use App\Models\AttractionFacilityDetailModel;
use App\Models\AttractionTicketPriceModel;

class Attraction extends ResourceController
{
    use ResponseTrait;

    protected $rumahGadangModel;
    protected $galleryRumahGadangModel;
    protected $detailFacilityRumahGadangModel;
    protected $reviewModel;

    protected $homestayModel;
    protected $attractionModel;
    protected $attractionGalleryModel;
    protected $attractionFacilityDetailModel;
    protected $attractionTicketPriceModel;

    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        $this->reviewModel = new ReviewModel();

        $this->homestayModel = new HomestayModel();
        $this->attractionModel = new AttractionModel();
        $this->attractionGalleryModel = new AttractionGalleryModel();
        $this->attractionFacilityDetailModel = new AttractionFacilityDetailModel();
        $this->attractionTicketPriceModel = new AttractionTicketPriceModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $attraction = array();
        $contents = $this->attractionModel->get_list_oat_api()->getResult();
        foreach ($contents as $content) {
            $list_gallery = $this->attractionGalleryModel->get_gallery_api($content->id)->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            if (empty($galleries)) {
                $content->gallery = null;
            } else {
                $content->gallery = $galleries[0];
            }
            $attraction[] = $content;
        }
        $response = [
            'data' => $attraction,
            'status' => 200,
            'message' => [
                "Success get list of Attraction"
            ]
        ];
        return $this->respond($response);
    }

    public function uIndex()
    {
        $attraction = array();
        $contents = $this->attractionModel->get_uat_api()->getResult();
        foreach ($contents as $content) {
            $list_gallery = $this->attractionGalleryModel->get_gallery_api($content->id)->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            if (empty($galleries)) {
                $content->gallery = null;
            } else {
                $content->gallery = $galleries[0];
            }
            $attraction[] = $content;
        }
        $response = [
            'data' => $attraction,
            'status' => 200,
            'message' => [
                "Success get list of Attraction"
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
        $attraction = $this->attractionModel->get_at_by_id_api($id)->getRowArray();
        $attraction['price'] = 'Rp ' . number_format($attraction['price'], 0, ',', '.');
        $list_gallery = $this->attractionGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $list_facility = $this->attractionFacilityDetailModel->get_facility_by_at_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }

        
        $attraction['facilities'] = $facilities;
        $attraction['gallery'] = $galleries;

        $response = [
            'data' => $attraction,
            'status' => 200,
            'message' => [
                "Success display detail information of Attraction"
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
        $id = $this->rumahGadangModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'price' => $request['price'],
            'contact_person' => $request['contact_person'],
            'status' => $request['status'],
            'recom' => $request['recom'],
            'owner' => $request['owner'],
            'description' => $request['description'],
            'video_url' => $request['video_url'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geojson'];
        $addRG = $this->rumahGadangModel->add_rg_api($requestData, $geojson);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilityRumahGadangModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryRumahGadangModel->add_gallery_api($id, $gallery);
        if ($addRG && $addFacilities && $addGallery) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Rumah Gadang"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Rumah Gadang",
                    "Add Rumah Gadang: {$addRG}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
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
            'open' => $request['open'],
            'close' => $request['close'],
            'price' => $request['price'],
            'contact_person' => $request['contact_person'],
            'status' => $request['status'],
            'recom' => $request['recom'],
            'owner' => $request['owner'],
            'description' => $request['description'],
            'video_url' => $request['video_url'],
        ];
        $geojson = $request['geojson'];
        $updateRG = $this->rumahGadangModel->update_rg_api($id, $requestData, $geojson);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilityRumahGadangModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryRumahGadangModel->update_gallery_api($id, $gallery);
        if ($updateRG && $updateFacilities && $updateGallery) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success update Rumah Gadang"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Rumah Gadang",
                    "Update Rumah Gadang: {$updateRG}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
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
        $deleteHS = $this->attractionModel->delete(['id' => $id]);
        if ($deleteHS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Attraction"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Attraction not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function recommendation()
    {

        $contents = $this->rumahGadangModel->get_recommendation_api()->getResultArray();
        for ($index = 0; $index < count($contents); $index++) {
            $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($contents[$index]['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$index]['gallery'] = $galleries;
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of recommended Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }

    public function recommendationByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->rumahGadangModel->recommendation_by_owner_api($request['id'])->getResultArray();
        for ($index = 0; $index < count($contents); $index++) {
            $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($contents[$index]['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$index]['gallery'] = $galleries;
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of recommended Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }

    public function recommendationList()
    {
        $contents = $this->rumahGadangModel->get_recommendation_data_api()->getResultArray();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of recommendation"
            ]
        ];
        return $this->respond($response);
    }

    public function updateRecommendation()
    {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $request['id'],
            'recom' => $request['recom']
        ];
        $updateRecom = $this->rumahGadangModel->update_recom_api($requestData);
        if ($updateRecom) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Rumah Gadang Recommendation"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Rumah Gadang Recommendation",
                    "Update Rumah Gadang Recommendation: {$updateRecom}",
                ]
            ];
            return $this->respond($response, 400);
        }
    }

    public function findByName()
    {
        $request = $this->request->getPost();
        $name = $request['name'];
        $contents = $this->attractionModel->get_at_by_name_api($name)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Attraction by name"
            ]
        ];
        return $this->respond($response);
    }

    public function findByRadius()
    {
        $request = $this->request->getPost();
        if ($request['category'] == '1') {
            $contents = $this->attractionModel->get_uat_api()->getResultArray();
        } else {
            $contents = $this->attractionModel->get_list_oat_api()->getResultArray();
        }
        // $contents = $this->attractionModel->get_list_at_api()->getResultArray();
        $i = 0;
        foreach ($contents as $content) {

            $isWithinRadius = $this->isWithinRadius($request['lat'], $request['long'], $content['lat'], $content['lng'], (int)$request['radius'] / 1000);
            if (!$isWithinRadius) {
                unset($contents[$i]);
            }
            $i++;
        }
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Attraction by radius"
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

    public function getFacility()
    {
        $contents = $this->attractionModel->get_list_fc_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of facility"
            ]
        ];
        return $this->respond($response);
    }

    public function findByFacility()
    {
        $request = $this->request->getPost();
        $facility = $request['facility'];
        $list_facility = $this->attractionFacilityDetailModel->get_facility_by_fc_api($facility)->getResultArray();
        $attraction_id = array();
        foreach ($list_facility as $facil) {
            $attraction_id[] = $facil['attraction_id'];
        }
        $contents = $this->attractionModel->get_at_in_id_api($attraction_id)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Attraction by facility"
            ]
        ];
        return $this->respond($response);
    }

    public function findByRating()
    {
        $request = $this->request->getPost();
        $rating = $request['rating'];
        $list_rating = $this->reviewModel->get_object_by_rating_api('rumah_gadang_id', $rating)->getResultArray();
        $rumah_gadang_id = array();
        foreach ($list_rating as $rat) {
            $rumah_gadang_id[] = $rat['rumah_gadang_id'];
        }
        if (count($rumah_gadang_id) > 0) {
            $contents = $this->rumahGadangModel->get_rg_in_id_api($rumah_gadang_id)->getResult();
        } else {
            $contents = [];
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Rumah Gadang by rating"
            ]
        ];
        return $this->respond($response);
    }

    public function findByCategory()
    {
        $request = $this->request->getPost();
        $status = $request['category'];
        $contents = $this->rumahGadangModel->get_rg_by_status_api($status)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Rumah Gadang by status"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->rumahGadangModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }

    function findAll()
    {
        $request = $this->request->getPost();
        if ($request['category'] == '1') {
            $contents = $this->attractionModel->get_uat_api()->getResult();
        } else {
            $contents = $this->attractionModel->get_list_oat_api()->getResult();
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find all homestay"
            ]
        ];
        return $this->respond($response);
    }

    public function getATTCat()
    {
        $contents = $this->attractionModel->get_list_attcat_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Owner"
            ]
        ];
        return $this->respond($response);
    }

    public function attractionMobile(){
        $contents = $this->attractionModel->get_list_at_api_mobile()->getResult();
        foreach ($contents as $content) {
            $list_gallery = $this->attractionGalleryModel->get_gallery_api($content->id)->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            if (empty($galleries)) {
                $content->gallery = null;
            } else {
                $content->gallery = $galleries[0];
            }
            $attraction[] = $content;
        }
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
