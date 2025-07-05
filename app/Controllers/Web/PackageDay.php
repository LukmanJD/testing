<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\PackageModel;
use App\Models\PackageDayModel;
use App\Models\PackageDetailModel;

use App\Models\ReservationModel;
use App\Models\AttractionModel;
use App\Models\EventModel;

class PackageDay extends ResourcePresenter
{
    use ResponseTrait;

    protected $packageModel;
    protected $packageDayModel;
    protected $packageDetailModel;

    protected $reservationModel;
    protected $attractionModel;
    protected $eventModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->packageDayModel = new PackageDayModel();
        $this->packageDetailModel = new PackageDetailModel();

        $this->reservationModel = new ReservationModel();
        $this->attractionModel = new AttractionModel();
        $this->eventModel = new EventModel();
    }

    public function create()
    {
        $request = $this->request->getPost();

        $requestData = [
            'homestay_id' => $request['homestay_id'],
            'package_id' => $request['package_id'],
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $add = $this->packageDayModel->add_pd_api($requestData);

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
    public function delete($homestay_id = null, $package_id = null, $day = null)
    {

        $activities = $this->packageDetailModel->get_list_activity_by_day($homestay_id, $package_id, $day)->getResultArray();
        foreach ($activities as $activity) {
            $delete_activity = $this->deleteActivity($activity['homestay_id'], $activity['package_id'], $activity['day'], $activity['activity']);
        }

        $delete = $this->packageDayModel->delete_pd_api($homestay_id, $package_id, $day);

        if ($delete) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Package Day"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Package Day not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function deleteActivity($homestay_id = null, $package_id = null, $day = null, $activity = null)
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

        $delete = $this->packageDetailModel->delete_pd_api($homestay_id, $package_id, $day, $activity);

        return $delete;
    }
}
