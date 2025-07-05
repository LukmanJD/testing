<?php

namespace App\Controllers\Api;

// use App\Models\DetailFacilityRumahGadangModel;
// use App\Models\GalleryRumahGadangModel;
// use App\Models\ReviewModel;
// use App\Models\RumahGadangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

use App\Models\Homestay\HomestayModel;
use App\Models\Homestay\HomestayGalleryModel;
use App\Models\Homestay\HomestayFacilityDetailModel;
use App\Models\Homestay\HomestayUnitModel;
use App\Models\Homestay\HomestayUnitFacilityModel;
use App\Models\Homestay\HomestayUnitFacilityDetailModel;

use App\Models\VillageModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;
use App\Models\Reservation\ReservationModel;

class Homestay extends ResourceController
{
    use ResponseTrait;

    // protected $rumahGadangModel;
    // protected $galleryRumahGadangModel;
    // protected $detailFacilityRumahGadangModel;
    // protected $reviewModel;

    protected $homestayModel;
    protected $homestayGalleryModel;
    protected $homestayFacilityDetailModel;
    protected $homestayUnitModel;
    protected $homestayUnitFacilityModel;
    protected $homestayUnitFacilityDetailModel;

    protected $villageModel;
    protected $reservationHomestayUnitDetailModel;
    protected $reservationModel;

    public function __construct()
    {
        // $this->rumahGadangModel = new RumahGadangModel();
        // $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        // $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        // $this->reviewModel = new ReviewModel();

        $this->homestayModel = new HomestayModel();
        $this->homestayGalleryModel = new HomestayGalleryModel();
        $this->homestayFacilityDetailModel = new HomestayFacilityDetailModel();
        $this->homestayUnitModel = new HomestayUnitModel();
        $this->homestayUnitFacilityModel = new HomestayUnitFacilityModel();
        $this->homestayUnitFacilityDetailModel = new HomestayUnitFacilityDetailModel();

        $this->villageModel = new VillageModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
        $this->reservationModel = new ReservationModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $homestay = array();
        $contents = $this->homestayModel->get_list_hs_api()->getResultArray();
        foreach ($contents as $content) {
            $list_gallery = $this->homestayGalleryModel->get_gallery_api($content['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            if (empty($galleries)) {
                $content['gallery'] = null;
            } else {
                $content['gallery'] = $galleries[0];
            }
            $homestay[] = $content;
        }
        $homestay = $this->checkIsInsideVillage($homestay);

        $homestay = array_values($homestay);
        $response = [
            'data' => $homestay,
            'status' => 200,
            'message' => [
                "Success get list of Homestay"
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
        $homestay = $this->homestayModel->get_hs_by_id_api($id)->getRowArray();
        $unit_homestay = $this->homestayUnitModel->get_list_hu_api($id)->getResultArray();
        $prices = array_column($unit_homestay, 'price');
        // Cek apakah semua harga sama
        if (!empty($prices)) {
            // Cek apakah semua harga sama
            if (count(array_unique($prices)) === 1) {
                $unit_price = 'Rp' . number_format(esc($prices[0]), 0, ',', '.');
            } else {
                $minPrice = min($prices);
                $maxPrice = max($prices);
                $unit_price = 'Rp ' . number_format(esc($minPrice), 0, ',', '.') . ' - Rp ' . number_format(esc($maxPrice), 0, ',', '.');
            }
        } else {
            $unit_price = 'Harga belum tersedia';
        }
        // if (count(array_unique($prices)) === 1) {
        //     $unit_price = 'Rp' . number_format(esc($prices[0]), 0, ',', '.');
        //     // echo "Semua harga sama: " . $prices[0];
        // } else {
        //     $minPrice = min($prices);
        //     $maxPrice = max($prices);
        //     $unit_price = 'Rp ' . number_format(esc($minPrice), 0, ',', '.') . ' - ' . 'Rp ' . number_format(esc($maxPrice), 0, ',', '.');
        //     // echo "Harga bervariasi dari: " . $minPrice . " - " . $maxPrice;
        // }

        $list_gallery = $this->homestayGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $list_facility = $this->homestayFacilityDetailModel->get_facility_by_hs_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }

        // $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();
        // $avg_rating = $this->reviewModel->get_rating('rumah_gadang_id', $id)->getRowArray()['avg_rating'];

        $homestay['facilities'] = $facilities;
        $homestay['gallery'] = $galleries;
        $homestay['price'] = $unit_price;
        // $rumahGadang['avg_rating'] = $avg_rating;
        // $rumahGadang['reviews'] = $list_review;

        $response = [
            'data' => $homestay,
            'status' => 200,
            'message' => [
                "Success display detail information of Homestay"
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
            'ticket_price' => $request['ticket_price'],
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
            'ticket_price' => $request['ticket_price'],
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
        $deleteHS = $this->homestayModel->delete(['id' => $id]);
        if ($deleteHS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Homestay"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Homestay not found"
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
        $contents = $this->homestayModel->get_hs_by_name_api($name)->getResultArray();

        $contents = $this->checkIsInsideVillage($contents);

        $contents = array_values($contents);

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Homestay by name"
            ]
        ];
        return $this->respond($response);
    }

    public function findByRadius()
    {
        $request = $this->request->getPost();
        $contents = $this->homestayModel->get_list_hs_api()->getResultArray();
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
                "Success find Homestay by radius"
            ]
        ];
        return $this->respond($response);
    }

    public function findByFacility()
    {
        $request = $this->request->getPost();
        $facility = $request['facility'];
        $list_facility = $this->homestayFacilityDetailModel->get_facility_by_fc_api($facility)->getResultArray();
        $homestay_id = array();
        foreach ($list_facility as $facil) {
            $homestay_id[] = $facil['homestay_id'];
        }
        $contents = $this->homestayModel->get_hs_in_id_api($homestay_id)->getResultArray();

        $contents = $this->checkIsInsideVillage($contents);

        $contents = array_values($contents);

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Homestay by facility"
            ]
        ];
        return $this->respond($response);
    }

    public function findByRating()
    {
        $request = $this->request->getPost();

        $village = $this->villageModel->check_village()->getRowArray();

        $homestays = $this->homestayModel->get_hs_by_vil_id($village['id'])->getResultArray();

        $contents = array();

        foreach ($homestays as $homestay) {
            $getRID = $this->reservationHomestayUnitDetailModel->get_reservation_by_hs_api($homestay['id'])->getResultArray();

            $rating_review = array();
            $rating = 0;
            $rating_divider = 0;
            foreach ($getRID as $rid) {
                $reservation = $this->reservationModel->get_reservation_by_id($rid['reservation_id'])->getRowArray();
                if ($reservation['rating'] != null) {
                    $user = $this->reservationModel->get_cust($reservation['customer_id'])->getRowArray();
                    $rr['username'] = $user['username'];
                    $rr['rating'] = $reservation['rating'];
                    $rr['review'] = $reservation['review'];
                    $rating_review[] = $rr;
                    $rating = $rating + $reservation['rating'];
                    $rating_divider++;
                }
            }
            if ($rating != 0) {
                $avg_rating = $rating / $rating_divider;
                $avg_rating = floor($avg_rating);
            } else {
                $avg_rating = 0;
            }
            // dd($avg_rating);

            if ($avg_rating == (int)$request['rating']) {
                $contents[] = $this->homestayModel->get_hs_by_id_api($homestay['id'])->getRowArray();
            }
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Homestay by rating"
            ]
        ];
        return $this->respond($response);
    }

    public function findByUnit()
    {
        $request = $this->request->getPost();
        $unit_type = $request['unit'];

        $village = $this->villageModel->check_village()->getRowArray();

        $homestays = $this->homestayModel->get_hs_by_vil_id($village['id'])->getResultArray();

        $contents = array();

        foreach ($homestays as $homestay) {
            $isUnitTypeThere = $this->homestayUnitModel->get_hs_by_hsid_unittype($homestay['id'], $unit_type)->getResultArray();

            if ($isUnitTypeThere) {
                $contents[] = $this->homestayModel->get_hs_by_id_api($homestay['id'])->getRowArray();
            }
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Homestay by Unit"
            ]
        ];
        return $this->respond($response);
    }

    public function findByCategory()
    {
        $request = $this->request->getPost();
        $category = $request['category'];

        $village = $this->villageModel->check_village()->getRowArray();

        $homestays = $this->homestayModel->get_hs_by_cat($village['id'], $category)->getResultArray();

        foreach ($homestays as $homestay) {
            $contents[] = $this->homestayModel->get_hs_by_id_api($homestay['id'])->getRowArray();
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Homestay by Category"
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
    public function homestayUnitFac($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $id_fac_owned = $this->homestayUnitFacilityDetailModel->get_facility_id_by_hu_api($homestay_id, $unit_type, $unit_number)->getResultArray();
        $newData = array();
        foreach ($id_fac_owned as $row) {
            $newData[] = $row['facility_id'];
        }
        $id_fac_owned = $newData;
        if (empty($id_fac_owned)) {
            $contents = $this->homestayUnitFacilityModel->get_list_fc_api()->getResult();
        } else {
            $contents = $this->homestayUnitFacilityModel->get_list_huf_not_owned_api($id_fac_owned)->getResult();
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Facility"
            ]
        ];
        return $this->respond($response);
    }
    public function getNameByUser($id = null)
    {
        $homestay = $this->homestayModel->getNameByUser($id)->getRowArray();
        // dd($homestay['name']);
        $response = [
            'data' => $homestay['name'],
        ];
        return $this->respond($response);
    }
    public function getFacility()
    {
        $contents = $this->homestayModel->get_list_fc_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of facility"
            ]
        ];
        return $this->respond($response);
    }
    public function checkIsInsideVillage($contents = null)
    {
        $village = $this->villageModel->check_village()->getRowArray();

        $filePath = realpath(WRITEPATH . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'map' . DIRECTORY_SEPARATOR . 'tourism_village' . DIRECTORY_SEPARATOR . $village['geom_file']);

        // Read the content of the GeoJSON file
        $geoJsonContent = file_get_contents($filePath);

        // Decode the GeoJSON content into a PHP object or array
        $geoJsonData = json_decode($geoJsonContent, true);

        $polygon  = $geoJsonData['features'][0]['geometry']['coordinates'][0];

        // Tambahkan validasi format polygon
        if (!is_array($polygon[0])) {
            throw new \Exception("Invalid polygon format in GeoJSON.");
        }

        $i = 0;
        foreach ($contents as $content) {
            $point = [(float)$content['lng'], (float)$content['lat']];
            $isInside = $this->isPointInPolygon($point, $polygon);
            if (!$isInside) {
                unset($contents[$i]);
            }
            $i++;
        }

        // $polygon  = $geoJsonData['features'][0]['geometry']['coordinates'][0][0];

        // $i = 0;
        // foreach ($contents as $content) {
        //     $point = [(float)$content['lng'], (float)$content['lat']];

        //     $isInside = $this->isPointInPolygon($point, $polygon);

        //     // Display the result
        //     if (!$isInside) {
        //         unset($contents[$i]);
        //     }
        //     $i++;
        // }

        return $contents;
    }
    private function isPointInPolygon($point, $polygon)
    {
        $x = $point[0]; // Latitude of the point
        $y = $point[1]; // Longitude of the point
        $inside = false; // Initialize the inside status as false
        $n = count($polygon); // Number of vertices in the polygon

        // Loop through each edge of the polygon
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][0]; // Current vertex X (latitude)
            $yi = $polygon[$i][1]; // Current vertex Y (longitude)
            $xj = $polygon[$j][0]; // Previous vertex X (latitude)
            $yj = $polygon[$j][1]; // Previous vertex Y (longitude) 

            // Check if the point is inside the edge's vertical range and compute intersection
            $intersect = (($yi > $y) != ($yj > $y)) &&
                ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);

            // If an intersection occurs, toggle the inside status
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside; // Return true if the point is inside, otherwise false
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
        $contents = $this->homestayModel->get_list_hs_api()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find all homestay"
            ]
        ];
        return $this->respond($response);
    }
}
