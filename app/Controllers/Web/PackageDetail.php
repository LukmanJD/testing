<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\PackageModel;
use App\Models\PackageDetailModel;
use App\Models\AttractionModel;
use App\Models\EventModel;
use App\Models\HomestayExclusiveActivityModel;
use App\Models\CulinaryPlaceModel;
use App\Models\SouvenirPlaceModel;
use App\Models\ServiceProviderModel;
use App\Models\WorshipPlaceModel;
use App\Models\ReservationModel;

class PackageDetail extends ResourcePresenter
{
    use ResponseTrait;

    protected $packageModel;
    protected $packageDetailModel;
    protected $attractionModel;
    protected $eventModel;
    protected $homestayExclusiveActivityModel;
    protected $culinaryPlaceModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $worshipPlaceModel;
    protected $reservationModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->packageDetailModel = new PackageDetailModel();
        $this->attractionModel = new AttractionModel();
        $this->eventModel = new EventModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->reservationModel = new ReservationModel();
    }
    public function getObject($homestay_id = null, $package_id = null, $day = null, $date = null)
    {
        $activity = $this->packageDetailModel->get_list_activity_by_day($homestay_id, $package_id, $day)->getResultArray();
        if (empty($activity)) {
            $id_obj_not_included = ['AAA'];
        } else {
            $newData = array();
            foreach ($activity as $row) {
                $newData[] = $row['id_object'];
            }
            $id_obj_not_included = $newData;
        }

        $attractions = $this->attractionModel->get_att_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($attractions); $i++) {
            $attractions[$i]['activity_type'] = "Attraction";
            $attractions[$i]['price_for_package'] = "Rp " . number_format(esc($attractions[$i]['price_for_package']), 0, ',', '.') . "/person";
        }

        $events = $this->eventModel->get_evt_for_package($id_obj_not_included, $date)->getResultArray();
        for ($i = 0; $i < count($events); $i++) {
            $events[$i]['activity_type'] = "Event";
            $events[$i]['price_for_package'] = "Rp " . number_format(esc($events[$i]['price_for_package']), 0, ',', '.') . "/person";
        }

        $culinaryPlaces = $this->culinaryPlaceModel->get_cp_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($culinaryPlaces); $i++) {
            $culinaryPlaces[$i]['activity_type'] = "Culinary";
        }

        $souvenirPlaces = $this->souvenirPlaceModel->get_sp_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($souvenirPlaces); $i++) {
            $souvenirPlaces[$i]['activity_type'] = "Souvenir";
        }

        $serviceProviders = $this->serviceProviderModel->get_sp_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($serviceProviders); $i++) {
            $serviceProviders[$i]['activity_type'] = "Service Provider";
        }

        $worshipPlaces = $this->worshipPlaceModel->get_wp_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($worshipPlaces); $i++) {
            $worshipPlaces[$i]['activity_type'] = "Worship Place";
        }
        $objects =  array_merge($attractions, $events, $culinaryPlaces, $souvenirPlaces, $serviceProviders, $worshipPlaces);

        $response = [
            'data' => $objects,
            'status' => 200,
            'message' => [
                "Success get object list"
            ]
        ];
        return $this->respond($response);
    }
    public function create()
    {
        $request = $this->request->getPost();
        $activity = $this->packageDetailModel->get_new_activity($request['homestay_id'], $request['package_id'], $request['day']);

        $activity_type =  substr($request['id_object'], 0, 1);

        $requestData = [
            'homestay_id' => $request['homestay_id'],
            'package_id' => $request['package_id'],
            'day' => $request['day'],
            'activity' => $activity,
            'activity_type' => $activity_type,
            'id_object' => $request['id_object'],
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $add = $this->packageDetailModel->add_pd_api($requestData);

        $package = $this->packageModel->get_package_by_id_api($request['homestay_id'], $request['package_id'])->getRowArray();

        if ($activity_type == "A") {
            $attraction = $this->attractionModel->get_at_by_id_api($request['id_object'])->getRowArray();
            $package['price'] = (int)$package['price'] + ((int)$attraction['price_for_package'] * (int)$request['total_people']);
            $setPrice = $this->packageModel->set_price($package['price'], $request['homestay_id'], $request['package_id']);
        } elseif ($activity_type == "E") {
            $event = $this->eventModel->get_ev_by_id_api($request['id_object'])->getRowArray();
            $package['price'] = (int)$package['price'] + ((int)$event['ticket_price'] * (int)$request['total_people']);
            $setPrice = $this->packageModel->set_price($package['price'], $request['homestay_id'], $request['package_id']);
        }

        if ($add) {
            if (url_is('*web*')) {
                $package = $this->packageModel->get_package_by_id_api($request['homestay_id'], $request['package_id'])->getRowArray();
                if (str_contains($package['name'], 'extend')) {
                    return redirect()->to(base_url('web/reservation/package/extendPackage/' . $request['reservation_id'] . '/' . $request['homestay_id'] . '/' . $request['package_id']));
                } else {
                    return redirect()->to(base_url('web/reservation/package/customPackage/' . $request['reservation_id'] . '/' . $request['homestay_id'] . '/' . $request['package_id']));
                }
            }
            return redirect()->to(base_url('dashboard/tourismPackage/edit/' . $request['package_id']));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function delete($homestay_id = null, $package_id = null, $day = null, $activity = null)
    {
        $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();

        if (url_is('*web*')) {
            $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();
            if (str_contains($package['name'], 'extend')) {
                $reservation['total_people'] = $package['min_capacity'];
            } else {
                $reservation = $this->reservationModel->get_reservation_by_cpid($homestay_id, $package_id)->getRowArray();
            }
        } else {
            $reservation['total_people'] = $package['min_capacity'];
        }

        $package_detail = $this->packageDetailModel->get_pd_by_id($homestay_id, $package_id, $day, $activity)->getRowArray();

        if ($package_detail['activity_type'] == "A") {
            $attraction = $this->attractionModel->get_at_by_id_api($package_detail['id_object'])->getRowArray();
            $package['price'] = (int)$package['price'] - ((int)$attraction['price_for_package'] * (int)$reservation['total_people']);
            $setPrice = $this->packageModel->set_price($package['price'], $homestay_id, $package_id);
        } elseif ($package_detail['activity_type'] == "E") {
            $event = $this->eventModel->get_ev_by_id_api($package_detail['id_object'])->getRowArray();
            $package['price'] = (int)$package['price'] - ((int)$event['ticket_price'] * (int)$reservation['total_people']);
            $setPrice = $this->packageModel->set_price($package['price'], $homestay_id, $package_id);
        }

        $lastActivity = (int)($this->packageDetailModel->get_new_activity($homestay_id, $package_id, $day)) - 1;

        $delete = $this->packageDetailModel->delete_pd_api($homestay_id, $package_id, $day, $activity);

        if ((int)$package_detail['activity'] != $lastActivity) {
            for ($i = (int)$package_detail['activity'] + 1; $i <= $lastActivity; $i++) {
                $package_detail_move = $this->packageDetailModel->get_pd_by_id($homestay_id, $package_id, $day, $i)->getRowArray();
                $package_detail_move['activity'] = $i - 1;
                $add = $this->packageDetailModel->add_pd_api($package_detail_move);
                $delete_package_detail_move = $this->packageDetailModel->delete_pd_api($homestay_id, $package_id, $day, $i);
            }
        }

        if ($delete) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Activity"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Activity not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
