<?php

namespace App\Controllers\Web\AdditionalAmenities;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\Homestay\HomestayModel;
use App\Models\Homestay\HomestayAdditionalAmenitiesModel;
use App\Models\Homestay\HomestayExclusiveActivityModel;

use App\Models\Reservation\ReservationModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;
use App\Models\Reservation\ReservationHomestayActivityDetailModel;
use App\Models\Reservation\ReservationHomestayAdditionalAmenitiesDetailModel;

class AdditionalAmenities extends ResourcePresenter
{
    use ResponseTrait;

    protected $homestayModel;
    protected $homestayAdditionalAmenitiesModel;
    protected $homestayExclusiveActivityModel;

    protected $reservationModel;
    protected $reservationHomestayUnitDetailModel;
    protected $reservationHomestayActivityDetailModel;
    protected $reservationHomestayAdditionalAmenitiesDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->homestayModel = new HomestayModel();
        $this->homestayAdditionalAmenitiesModel = new HomestayAdditionalAmenitiesModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();

        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
        $this->reservationHomestayActivityDetailModel = new ReservationHomestayActivityDetailModel();
        $this->reservationHomestayAdditionalAmenitiesDetailModel = new ReservationHomestayAdditionalAmenitiesDetailModel();
    }

    public function index()
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $contents = $this->homestayAdditionalAmenitiesModel->get_list_haa_api($homestay['id'])->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['id'] = $contents[$i]['additional_amenities_id'];
        }

        $data = [
            'title' => 'Manage Homestay Additional Amenities',
            'category' => 'Homestay Additional Amenities',
            'data' => $contents,
        ];


        return view('dashboard/manage', $data);
    }
    public function create()
    {
        $request = $this->request->getPost();
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();

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

        $request['homestay_id'] = $homestay['id'];
        $request['image_url'] = $gallery[0];
        $addHS = $this->homestayAdditionalAmenitiesModel->add_haa_api($request);

        if ($addHS) {
            return redirect()->to(base_url('dashboard/additionalAmenities'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function update($activity_id = null)
    {
        $request = $this->request->getPost();
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();

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

        if (isset($request['is_order_count_per_day'])) {
            $request['is_order_count_per_day'] = '1';
        } else {
            $request['is_order_count_per_day'] = '0';
        }
        if (isset($request['is_order_count_per_person'])) {
            $request['is_order_count_per_person'] = '1';
        } else {
            $request['is_order_count_per_person'] = '0';
        }
        if (isset($request['is_order_count_per_room'])) {
            $request['is_order_count_per_room'] = '1';
        } else {
            $request['is_order_count_per_room'] = '0';
        }
        if (isset($request['additional_amenities_type'])) {
            $request['additional_amenities_type'] = '2';
        } else {
            $request['additional_amenities_type'] = '1';
        }

        $request['image_url'] = $gallery[0];
        $updateHS = $this->homestayAdditionalAmenitiesModel->update_haa_api($request, $homestay['id'], $activity_id);

        if ($updateHS) {
            return redirect()->to(base_url('dashboard/additionalAmenities'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function delete($homestay_id = null, $id = null)
    {
        $deleteS = $this->homestayAdditionalAmenitiesModel->del_activity($homestay_id, $id);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Additional Amenities"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Additional Amenities not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    public function getListAdditionalAmenities($homestay_id = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
        $contents = $this->homestayAdditionalAmenitiesModel->get_list_haa_api($homestay_id)->getResultArray();
        for ($i = 0; $i < count($contents); $i++) {
            $getRID = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_res_by_act_id($homestay_id, $contents[$i]['additional_amenities_id'])->getResultArray();
            $rating = 0;
            $rating_divider = 0;
            foreach ($getRID as $rid) {
                $reservation = $this->reservationModel->get_reservation_by_id($rid['reservation_id'])->getRowArray();
                if ($reservation['rating'] != null) {
                    $rating = $rating + $reservation['rating'];
                    $rating_divider++;
                }
            }
            if ($rating != 0) {
                $avg_rating = $rating / $rating_divider;
            } else {
                $avg_rating = 0;
            }
            $contents[$i]['avg_rating'] = $avg_rating;
            $contents[$i]['id'] = $contents[$i]['additional_amenities_id'];
        }
        $data = [
            'title' => $homestay['name'],
            'category' => 'Homestay Additional Amenities',
            'data' => $contents,
        ];

        $data['homestay_id'] = $homestay_id;

        return view('web/homestay_activity_list', $data);
    }

    public function getAdditionalAmenities($homestay_id = null, $reservation_id = null)
    {

        $amenities = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_haa_by_rid_api($homestay_id, $reservation_id)->getResultArray();

        if (empty($amenities)) {
            $id_obj_not_included = ['AAA'];
        } else {
            $newData = array();
            foreach ($amenities as $row) {
                $newData[] = $row['additional_amenities_id'];
            }
            $id_obj_not_included = $newData;
        }
        $data = $this->homestayAdditionalAmenitiesModel->get_haa_for_res($id_obj_not_included, $homestay_id)->getResultArray();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['real_price'] = $data[$i]['price'];
            $price_det = '';
            if ($data[$i]['is_order_count_per_day'] == '1') {
                $price_det = $price_det . '/day';
            }
            if ($data[$i]['is_order_count_per_person'] == '1') {
                $price_det = $price_det . '/person';
            }
            if ($data[$i]['is_order_count_per_room'] == '1') {
                $price_det = $price_det . '/room';
            }
            $data[$i]['price'] = "Rp " . number_format($data[$i]['price'], 0, ',', '.') . $price_det;

            if ($data[$i]['stock'] != 0) {
                $dates = $this->reservationHomestayUnitDetailModel->get_date_by_rid($reservation_id)->getResultArray();
                if (empty($dates)) {
                    $date = ['AAA'];
                } else {
                    $newData = array();
                    foreach ($dates as $row) {
                        $newData[] = $row['date'];
                    }
                    $date = $newData;
                }
                $rids = $this->reservationHomestayUnitDetailModel->get_rid_in_date($date)->getResultArray();
                if (empty($rids)) {
                    $rid = ['AAA'];
                } else {
                    $newData = array();
                    foreach ($rids as $row) {
                        $newData[] = $row['reservation_id'];
                    }
                    $rid = $newData;
                }

                $stock_booked = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_amenities_stock_booked($homestay_id, $data[$i]['additional_amenities_id'], $rid)->getResultArray();
                // dd($stock_booked);
                $data[$i]['available_stock'] = (int)$data[$i]['stock'] - (int)$stock_booked[0]['sum(total_order)'];
            }
        }

        $response = [
            'data' => $data,
            'status' => 200,
            'message' => [
                "Success get additional amenities list"
            ]
        ];
        return $this->respond($response);
    }

    public function deleteAdditionalAmenities($homestay_id = null, $additional_amenities_id = null, $reservation_id = null)
    {
        $deleteS = $this->reservationHomestayAdditionalAmenitiesDetailModel->del_haa_by_id_api($homestay_id, $additional_amenities_id, $reservation_id);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Additional Amenities"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Additional Amenities not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function detailAdditionalAmenitiesMobile($homestay_id = null, $additional_amenities_id = null)
    {
        $additional_amenities = $this->homestayAdditionalAmenitiesModel->get_haa_by_id_api($homestay_id, $additional_amenities_id)->getRowArray();
        for ($i = 0; $i < count($additional_amenities); $i++) {
            $getRID = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_res_by_act_id($homestay_id, $additional_amenities['additional_amenities_id'])->getResultArray();
            $rating = 0;
            $rating_divider = 0;
            foreach ($getRID as $rid) {
                $reservation = $this->reservationModel->get_reservation_by_id($rid['reservation_id'])->getRowArray();
                if ($reservation['rating'] != null) {
                    $rating = $rating + $reservation['rating'];
                    $rating_divider++;
                }
            }
            if ($rating != 0) {
                $avg_rating = $rating / $rating_divider;
            } else {
                $avg_rating = 0;
            }
            $additional_amenities['avg_rating'] = $avg_rating;
            $additional_amenities['id'] = $additional_amenities['additional_amenities_id'];
        }
        $data['data'] = $additional_amenities;
        $data['title'] = 'Additional Amenities Detail';
        return view('maps/additional_amenities_detail', $data);
    }
}
