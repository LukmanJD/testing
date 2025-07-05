<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\HomestayModel;
use App\Models\PackageModel;
use App\Models\PackageDetailModel;
use App\Models\PackageServiceDetailModel;
use App\Models\PackageDayModel;
use App\Models\AttractionModel;
use App\Models\CulinaryPlaceModel;
use App\Models\SouvenirPlaceModel;
use App\Models\ServiceProviderModel;
use App\Models\WorshipPlaceModel;
use App\Models\HomestayExclusiveActivityModel;
use App\Models\EventModel;

use App\Models\ReservationModel;
use App\Models\ReservationHomestayUnitDetailModel;

class TourismPackage extends ResourcePresenter
{
    use ResponseTrait;

    protected $homestayModel;
    protected $packageModel;
    protected $packageDetailModel;
    protected $packageServiceDetailModel;
    protected $packageDayModel;
    protected $attractionModel;
    protected $culinaryPlaceModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $worshipPlaceModel;
    protected $homestayExclusiveActivityModel;
    protected $eventModel;

    protected $reservationModel;
    protected $reservationHomestayUnitDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->homestayModel = new HomestayModel();
        $this->packageModel = new PackageModel();
        $this->packageDetailModel = new PackageDetailModel();
        $this->packageServiceDetailModel = new PackageServiceDetailModel();
        $this->packageDayModel = new PackageDayModel();
        $this->attractionModel = new AttractionModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();
        $this->eventModel = new EventModel();

        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
    }
    public function index()
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $contents = $this->packageModel->list_by_homestay_api($homestay['id'])->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['id'] = $contents[$i]['package_id'];
        }

        $data = [
            'title' => 'Manage Package',
            'category' => 'Package',
            'data' => $contents,
        ];

        return view('dashboard/manage', $data);
    }
    public function new()
    {
        $data = [
            'title' => 'New Package',
        ];
        return view('dashboard/package_form', $data);
    }

    public function create()
    {

        $request = $this->request->getPost();
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();

        $package_new_id = $this->packageModel->get_new_id_api($homestay['id']);

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
        } else {
            $gallery[0] = null;
        }
        $request['is_custom'] = "00";
        $requestData = [
            'package_id' => $package_new_id,
            'homestay_id' => $homestay['id'],
            'name' => $request['name'],
            'min_capacity' => $request['min_capacity'],
            'description' => $request['description'],
            'brochure_url' => $gallery[0],
            'is_custom' => $request['is_custom'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addHS = $this->packageModel->add_package_api($requestData);

        if ($addHS) {
            return redirect()->to(base_url('dashboard/tourismPackage/edit/' . $package_new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function edit($id = null)
    {

        if (url_is('*dashboard*')) {
            $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
            $homestay_id = $homestay['id'];
        }

        $data = $this->getPackageDetail($homestay_id, $id);

        $data['title'] = 'Manage Package';

        return view('dashboard/package_form', $data);
    }

    public function update($id = null)
    {
        if (url_is('*dashboard*')) {
            $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
            $homestay_id = $homestay['id'];
        }
        $request = $this->request->getPost();

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
        } else {
            $gallery[0] = null;
        }
        $request['is_custom'] = "00";
        $requestData = [
            'name' => $request['name'],
            'min_capacity' => $request['min_capacity'],
            'price' => $request['price'],
            'description' => $request['description'],
            'brochure_url' => $gallery[0],
            'is_custom' => $request['is_custom'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $update = $this->packageModel->update_package_api($requestData, $homestay_id, $id);

        if ($update) {
            return redirect()->to(base_url('dashboard/tourismPackage/edit/' . $id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function show($homestay_id = null, $package_id = null)
    {
        if (url_is('*dashboard*')) {
            $package_id = $homestay_id;
            $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
            $homestay_id = $homestay['id'];
        }
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
        $data = $this->getPackageDetail($homestay_id, $package_id);
        $reservations = $this->reservationModel->get_reservation_by_cpid($homestay_id, $package_id)->getResultArray();
        $rating = 0;
        $rating_divider = 0;
        foreach ($reservations as $reservation) {
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
        $data['data']['avg_rating'] = $avg_rating;

        $data['title'] = 'Package Detail';

        $data['homestay'] = $homestay;
        if (url_is('*web*')) {
            $data['homestay_id'] = $data['data']['homestay_id'];
            $data['title'] = $homestay['name'];
            return view('web/package_detail', $data);
        }
        return view('dashboard/package_detail', $data);
    }
    public function getPackageDetail($homestay_id = null, $package_id = null)
    {
        $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();
        $package['gallery'] = [$package['brochure_url']];

        $package_day = $this->packageDayModel->get_pd_by_pacakage_id_api($homestay_id, $package_id)->getResultArray();

        $list_activity = $this->packageDetailModel->get_pd_by_pacakage_id_api($homestay_id, $package_id)->getResultArray();
        for ($i = 0; $i < count($list_activity); $i++) {
            if (substr($list_activity[$i]['id_object'], 0, 1) === 'A') {
                $list_activity[$i]['type'] = "Attraction";
                $attraction = $this->attractionModel->get_at_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $attraction['name'];
                $list_activity[$i]['price_for_package'] = $attraction['price_for_package'];
                $list_activity[$i]['lat'] = $attraction['lat'];
                $list_activity[$i]['lng'] = $attraction['lng'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'C') {
                $list_activity[$i]['type'] = "Culinary";
                $culinaryPlace = $this->culinaryPlaceModel->get_cp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $culinaryPlace['name'];
                $list_activity[$i]['lat'] = $culinaryPlace['lat'];
                $list_activity[$i]['lng'] = $culinaryPlace['lng'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'S') {
                $list_activity[$i]['type'] = "Souvenir";
                $souvenirPlace = $this->souvenirPlaceModel->get_sp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $souvenirPlace['name'];
                $list_activity[$i]['lat'] = $souvenirPlace['lat'];
                $list_activity[$i]['lng'] = $souvenirPlace['lng'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'V') {
                $list_activity[$i]['type'] = "Service Provider";
                $serviceProvider = $this->serviceProviderModel->get_sv_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $serviceProvider['name'];
                $list_activity[$i]['lat'] = $serviceProvider['lat'];
                $list_activity[$i]['lng'] = $serviceProvider['lng'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'W') {
                $list_activity[$i]['type'] = "Worship";
                $worshipPlace = $this->worshipPlaceModel->get_wp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $worshipPlace['name'];
                $list_activity[$i]['lat'] = $worshipPlace['lat'];
                $list_activity[$i]['lng'] = $worshipPlace['lng'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'E') {
                $list_activity[$i]['type'] = "Event";
                $event = $this->eventModel->get_ev_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $event['name'];
                $list_activity[$i]['lat'] = $event['lat'];
                $list_activity[$i]['lng'] = $event['lng'];
            } else {
                $list_activity[$i]['type'] = "Homestay Activity";
                $homestayActivity = $this->homestayExclusiveActivityModel->get_hea_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $homestayActivity['name'];
                $list_activity[$i]['lat'] = $homestayActivity['lat'];
                $list_activity[$i]['lng'] = $homestayActivity['lng'];
            }
        }

        $list_service = $this->packageServiceDetailModel->get_list_service_by_id($homestay_id, $package_id)->getResultArray();
        // dd($list_service);

        $package['id'] = $package['package_id'];
        $data = [
            'data' => $package,
            'list_day' => $package_day,
            'total_people' => $package['min_capacity'],
            'list_activity' => $list_activity,
            'list_service' => $list_service,
        ];
        return $data;
    }
    public function getListPackage($homestay_id = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
        $contents = $this->packageModel->list_by_homestay_api($homestay_id)->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $reservations = $this->reservationModel->get_reservation_by_cpid($homestay_id, $contents[$i]['package_id'])->getResultArray();
            $rating = 0;
            $rating_divider = 0;
            foreach ($reservations as $reservation) {
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
            $contents[$i]['id'] = $contents[$i]['package_id'];
            $package_detail = $this->packageDetailModel->get_pd_by_pacakage_id_api($homestay['id'], $contents[$i]['id'])->getResultArray();
            if (empty($package_detail)) {
                $contents[$i]['total_day'] = '0';
            } else {
                $contents[$i]['total_day'] = max(array_column($package_detail, 'day'));
            }
        }

        $data = [
            'title' => $homestay['name'],
            'category' => 'Package',
            'data' => $contents,
        ];

        $data['homestay_id'] = $homestay_id;

        return view('web/homestay_package_list', $data);
    }
    public function delete($homestay_id = null, $package_id = null)
    {
        $delete = $this->packageModel->del_package($homestay_id, $package_id);
        if ($delete) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Package"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Package not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
