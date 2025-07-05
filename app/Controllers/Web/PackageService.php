<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\ReservationModel;
use App\Models\PackageModel;
use App\Models\PackageDetailModel;
use App\Models\AttractionModel;
use App\Models\HomestayExclusiveActivityModel;
use App\Models\CulinaryPlaceModel;
use App\Models\SouvenirPlaceModel;
use App\Models\ServiceProviderModel;
use App\Models\WorshipPlaceModel;

use App\Models\PackageServiceModel;
use App\Models\PackageServiceDetailModel;

class PackageService extends ResourcePresenter
{
    use ResponseTrait;

    protected $reservationModel;
    protected $packageModel;
    protected $packageDetailModel;
    protected $attractionModel;
    protected $homestayExclusiveActivityModel;
    protected $culinaryPlaceModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $worshipPlaceModel;

    protected $packageServiceModel;
    protected $packageServiceDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
        $this->packageModel = new PackageModel();
        $this->packageDetailModel = new PackageDetailModel();
        $this->attractionModel = new AttractionModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();

        $this->packageServiceModel = new PackageServiceModel();
        $this->packageServiceDetailModel = new PackageServiceDetailModel();
    }
    public function getService($homestay_id = null, $package_id = null)
    {
        $service = $this->packageServiceDetailModel->get_list_service_by_id($homestay_id, $package_id)->getResultArray();

        if (empty($service)) {
            $id_obj_not_included = ['AAA'];
        } else {
            $newData = array();
            foreach ($service as $row) {
                $newData[] = $row['package_service_id'];
            }
            $id_obj_not_included = $newData;
        }

        $data = $this->packageServiceDetailModel->get_sv_for_package($id_obj_not_included)->getResultArray();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['category'] == "1") {
                $data[$i]['price'] = "Rp " . number_format(esc($data[$i]['price']), 0, ',', '.') . "/person";
            } else {
                $data[$i]['price'] = "Rp " . number_format(esc($data[$i]['price']), 0, ',', '.') . "/group";
            }
        }
        $response = [
            'data' => $data,
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

        $requestData = [
            'homestay_id' => $request['homestay_id'],
            'package_id' => $request['package_id'],
            'package_service_id' => $request['package_service_id'],
            'status' => $request['status'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $add = $this->packageServiceDetailModel->add_package_service($requestData);

        $package = $this->packageModel->get_package_by_id_api($request['homestay_id'], $request['package_id'])->getRowArray();

        $service = $this->packageServiceModel->get_psv_by_id($request['package_service_id'])->getRowArray();

        if ($request['status'] == "1") {
            if ($service['category'] == "1") {
                $package['price'] = (int)$package['price'] + ((int)$service['price'] * (int)$request['total_people']);
            } else {
                $package['price'] = (int)$package['price'] + (int)$service['price'];
            }
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
    public function delete($homestay_id = null, $package_id = null, $package_service_id = null)
    {
        $reservation = $this->reservationModel->get_reservation_by_cpid($homestay_id, $package_id)->getRowArray();

        $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();

        $service = $this->packageServiceModel->get_psv_by_id($package_service_id)->getRowArray();

        $package_service_detail = $this->packageServiceDetailModel->get_ps_by_id_api($homestay_id, $package_id, $package_service_id)->getRowArray();

        if (($package_service_detail['status'] == "1") && ($package['is_custom'] == '1')) {
            if ($service['category'] == "1") {
                $package['price'] = (int)$package['price'] - ((int)$service['price'] * (int)$reservation['total_people']);
            } else {
                $package['price'] = (int)$package['price'] - (int)$service['price'];
            }
            $setPrice = $this->packageModel->set_price($package['price'], $homestay_id, $package_id);
        } elseif (($package_service_detail['status'] == "1") && ($package['is_custom'] != '1')) {
            if ($service['category'] == "1") {
                $package['price'] = (int)$package['price'] - ((int)$service['price'] * (int)$package['min_capacity']);
            } else {
                $package['price'] = (int)$package['price'] - (int)$service['price'];
            }
            $setPrice = $this->packageModel->set_price($package['price'], $homestay_id, $package_id);
        }

        $delete = $this->packageServiceDetailModel->delete_ps_api($homestay_id, $package_id, $package_service_id);
        if ($delete) {
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
