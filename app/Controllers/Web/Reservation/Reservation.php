<?php

namespace App\Controllers\Web\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\Package\PackageModel;
use App\Models\Package\PackageDayModel;
use App\Models\Package\PackageDetailModel;
use App\Models\Package\PackageServiceDetailModel;
use App\Models\Homestay\HomestayModel;
use App\Models\Homestay\HomestayUnitModel;
use App\Models\Homestay\HomestayUnitGalleryModel;
use App\Models\Homestay\HomestayExclusiveActivityModel;
use App\Models\Homestay\HomestayAdditionalAmenitiesModel;
use App\Models\Reservation\ReservationModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;
use App\Models\Reservation\ReservationHomestayUnitDetailBackUpModel;
use App\Models\Reservation\ReservationHomestayActivityDetailModel;
use App\Models\Reservation\ReservationHomestayAdditionalAmenitiesDetailModel;
use App\Models\AccountModel;
use App\Controllers\Api\Notification;
use App\Models\Attraction\AttractionModel;
use App\Models\Culinary\CulinaryPlaceModel;
use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\ServiceProvider\ServiceProviderModel;
use App\Models\Worship\WorshipPlaceModel;
use App\Models\Event\EventModel;
use App\Models\User\UserBankAccountModel;
use Myth\Auth\Models\UserModel;

class Reservation extends ResourcePresenter
{
    use ResponseTrait;

    protected $packageModel;
    protected $packageDayModel;
    protected $packageDetailModel;
    protected $packageServiceDetailModel;
    protected $accountModel;
    protected $homestayModel;
    protected $homestayUnitModel;
    protected $homestayUnitGalleryModel;
    protected $homestayExclusiveActivityModel;
    protected $homestayAdditionalAmenitiesModel;
    protected $reservationModel;
    protected $reservationHomestayUnitDetailModel;
    protected $reservationHomestayUnitDetailBackUpModel;
    protected $reservationHomestayActivityDetailModel;
    protected $reservationHomestayAdditionalAmenitiesDetailModel;
    protected $notification;

    protected $attractionModel;
    protected $culinaryPlaceModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $worshipPlaceModel;
    protected $eventModel;
    protected $userBankAccountModel;
    protected $userModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->packageDayModel = new PackageDayModel();
        $this->packageDetailModel = new PackageDetailModel();
        $this->packageServiceDetailModel = new PackageServiceDetailModel();
        $this->accountModel = new AccountModel();
        $this->homestayModel = new HomestayModel();
        $this->homestayUnitModel = new HomestayUnitModel();
        $this->homestayUnitGalleryModel = new HomestayUnitGalleryModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();
        $this->homestayAdditionalAmenitiesModel = new HomestayAdditionalAmenitiesModel();
        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
        $this->reservationHomestayUnitDetailBackUpModel = new ReservationHomestayUnitDetailBackUpModel();
        $this->reservationHomestayActivityDetailModel = new ReservationHomestayActivityDetailModel();
        $this->reservationHomestayAdditionalAmenitiesDetailModel = new ReservationHomestayAdditionalAmenitiesDetailModel();
        $this->notification = new Notification();

        $this->attractionModel = new AttractionModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->eventModel = new EventModel();
        $this->userBankAccountModel = new UserBankAccountModel();
        $this->userModel = new UserModel();
    }

    public function listReservation()
    {
        $reservations = $this->reservationModel->get_list_reservation_by_cus_id(user()->id)->getResultArray();

        foreach ($reservations as $reservation) {
            if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
                $checkIsReservationCancel = $this->checkIsReservationCancel($reservation);
            }
            if ($reservation['status'] == 'Full Pay Successful') {
                $checkIsReservationDone = $this->checkIsReservationDone($reservation);
            }
        }

        $reservations = $this->reservationModel->get_list_reservation_by_cus_id(user()->id)->getResultArray();


        $data = [
            'title' => 'Reservation',
            'data' => $reservations,
        ];

        return view('web/reservation_list', $data);
    }

    private function mapWeatherCodeToIcon($weatherCode)
    {
        $icons = [
            0 => '01d',
            1 => '02d',
            2 => '02d',
            3 => '03d',
            45 => '50d',
            48 => '50d',
            51 => '09d',
            53 => '09d',
            55 => '09d',
            61 => '10d',
            63 => '10d',
            65 => '10d',
            80 => '09d',
            81 => '09d',
            82 => '09d',
            95 => '11d',
            96 => '11d',
            99 => '11d'
        ];

        return $icons[$weatherCode] ?? '02d.png';
    }

    private function mapWeatherCodeToDescription($weatherCode)
    {
        $descriptions = [
            0 => 'Clear',
            1 => 'Partly Cloudy',
            2 => 'Partly Cloudy',
            3 => 'Cloudy',
            45 => 'Foggy',
            48 => 'Dense Fog',
            51 => 'Light Drizzle',
            53 => 'Drizzle',
            55 => 'Heavy Drizzle',
            61 => 'Light Rain',
            63 => 'Rain',
            65 => 'Heavy Rain',
            80 => 'Rain Showers',
            81 => 'Rain Showers',
            82 => 'Heavy Showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm',
            99 => 'Severe Storm'
        ];

        return $descriptions[$weatherCode] ?? 'Weather condition unavailable';
    }

    // Updated fetch function to include weather descriptions
    private function fetchWeatherData($latitude, $longitude)
    {
        $api_url = "https://api.open-meteo.com/v1/forecast";
        $params = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'daily' => 'temperature_2m_min,temperature_2m_max,weathercode',
            'timezone' => 'auto',
            'forecast_days' => 14
        ];

        $query = http_build_query($params);
        $url = $api_url . '?' . $query;

        $client = \Config\Services::curlrequest();
        $response = $client->get($url);

        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody(), true);
            if (isset($result['daily'])) {
                $weatherData = $result['daily'];
                if (isset($weatherData['weathercode'])) {
                    foreach ($weatherData['weathercode'] as $index => $code) {
                        $weatherData['weather_icons'][$index] = $this->mapWeatherCodeToIcon($code);
                        $weatherData['weather_descriptions'][$index] = $this->mapWeatherCodeToDescription($code);
                    }
                }
                return $weatherData;
            }
        }

        return [];
    }

    public function newReservation($homestay_id = null)
    {
        $homestays = $this->homestayModel->get_list_hs_api()->getResultArray();
        $booked_dates = $this->reservationHomestayUnitDetailModel->get_date_by_hid($homestay_id);

        // bagian sini
        $weather_dates = [];
        $current_date = new \DateTime();
        for ($i = 0; $i < 14; $i++) {
            $weather_dates[] = $current_date->format('Y-m-d'); // Simpan dalam format Y-m-d
            $current_date->modify('+1 day'); // Tambahkan 1 hari
        }
        // sampai sini  

        // dari sini 
        // Ambil lat dan lon untuk homestay ini
        $homestay = $this->homestayModel->find($homestay_id); // Misalkan tabel homestay punya kolom lat dan lon
        $latitude = $homestay['lat'];
        $longitude = $homestay['lng'];

        $weather_data = $this->fetchWeatherData($latitude, $longitude);

        $weather_icons = [];
        $weather_descriptions = [];

        // Periksa apakah weathercode tersedia dan bukan array kosong
        if (!empty($weather_data['weathercode'])) {
            foreach ($weather_data['weathercode'] as $index => $code) {
                // Ambil ikon berdasarkan kode cuaca
                $icon = $this->mapWeatherCodeToIcon($code);
                $weather_icons[] = "https://openweathermap.org/img/wn/{$icon}@2x.png";

                // Ambil deskripsi berdasarkan kode cuaca
                $description = $this->mapWeatherCodeToDescription($code);
                $weather_descriptions[] = $description;
            }
        }
        // sampai sini

        if ($homestay_id === '' || $homestay_id === null) {

            $data = [
                'homestay_id' => null,
                'title' => 'Homestay Reservation',
                'homestays' => $homestays, // Ganti homestay_id dengan homestays untuk menampung daftar homestay
            ];
        } else {
            // $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
            $data = [
                'homestay_id' => $homestay_id,
                'title' => 'Homestay Reservation',
                // 'homestays' => $homestays, // Ubah ke homestay untuk menampung data spesifik homestay
                // 'booked_dates' => $booked_dates, //
                'weather_dates' => $weather_dates, // Tambahkan daftar 7 hari ke data yang dikirim
                'weather_data' => $weather_data,
                'weather_icons' => $weather_icons
            ];
        }
        // dd($data, $homestay);
        return view('web/reservation_form', $data);
    }


    public function getBookedDates($homestay_id)
    {
        // Ambil booked dates berdasarkan homestay_id
        $booked_dates = $this->reservationHomestayUnitDetailModel->get_date_by_hid($homestay_id);

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($booked_dates);
    }

    public function newReservationEvent($homestay_id = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();

        $date_disable = $this->reservationHomestayUnitDetailModel->get_date_disable()->getResultArray();

        $disabled_date = array();

        foreach ($date_disable as $date) {
            $disabled_date[] = $date['date'];
        }
        // dd(implode('", "', $disabled_date));

        $weather_dates = [];
        $current_date = new \DateTime();
        for ($i = 0; $i < 14; $i++) {
            $weather_dates[] = $current_date->format('Y-m-d'); // Simpan dalam format Y-m-d
            $current_date->modify('+1 day'); // Tambahkan 1 hari
        }

        $latitude = $homestay['lat'];
        $longitude = $homestay['lng'];

        // Panggil Open-Meteo API
        $weather_data = $this->fetchWeatherData($latitude, $longitude);

        $weather_icons = [];
        $weather_descriptions = [];

        // Periksa apakah weathercode tersedia dan bukan array kosong
        if (!empty($weather_data['weathercode'])) {
            foreach ($weather_data['weathercode'] as $index => $code) {
                // Ambil ikon berdasarkan kode cuaca
                $icon = $this->mapWeatherCodeToIcon($code);
                $weather_icons[] = "https://openweathermap.org/img/wn/{$icon}@2x.png";

                // Ambil deskripsi berdasarkan kode cuaca
                $description = $this->mapWeatherCodeToDescription($code);
                $weather_descriptions[] = $description;
            }
        }

        $data = [
            'title' =>  $homestay['name'] . ' Reservation',
            'homestay_id' => $homestay_id,
            'max_people_for_event' => $homestay['max_people_for_event'],
            'date_disabled' => $disabled_date,
            'weather_dates' => $weather_dates, // Tambahkan daftar 7 hari ke data yang dikirim
            'weather_data' => $weather_data,
            'weather_icons' => $weather_icons
        ];

        return view('web/reservation_event_form', $data);
    }

    public function getUnit($homestay_id = null, $unit_type = null, $check_in = null, $day_of_stay = null)
    {
        $number_not_available = array();
        for ($i = 0; $i < $day_of_stay; $i++) {
            $date = date('Y-m-d', strtotime($check_in));
            $unit_number_not_available = $this->reservationHomestayUnitDetailModel->get_unit_number_not_available($homestay_id, $unit_type, $date)->getResultArray();
            $check_in = date("Y-m-d", strtotime($date . ' + 1 days'));
            foreach ($unit_number_not_available as $row) {
                $number_not_available[] = $row['unit_number'];
            }
        }
        $number_not_available = array_unique($number_not_available);

        if (empty($number_not_available)) {
            $number_not_available = ['AAA'];
        }
        $homestay_unit = $this->homestayUnitModel->get_hu_in_number($homestay_id, $unit_type, $number_not_available)->getResultArray();

        for ($i = 0; $i < count($homestay_unit); $i++) {
            $getRID = $this->reservationHomestayUnitDetailModel->get_reservation_by_huid($homestay_id, $unit_type, $homestay_unit[$i]['unit_number'])->getResultArray();
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
            $homestay_unit[$i]['avg_rating'] = $avg_rating;
            $unit_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $unit_type, $homestay_unit[$i]['unit_number'])->getRowArray();
            $homestay_unit[$i]['url'] = $unit_gallery['url'];
        }

        if (empty($homestay_unit)) {
            $homestay_unit = 'Empty';
        }

        $response = [
            'data' => $homestay_unit,
            'status' => 200,
            'message' => [
                "Success get Homestay Unit Available"
            ]
        ];
        return $this->respond($response);
    }

    public function createReservation($homestay_id = null)
    {
        $request = $this->request->getPost();

        $new_id = $this->reservationModel->get_new_id_api();

        $total_price = 0;

        $homestay_units = array();
        for ($i = 0; $i < count($request['unit_number']); $i++) {
            $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id, $request['unit_type'], $request['unit_number'][$i])->getRowArray();
            $homestay_units[] = $homestay_unit;
            $total_price = $total_price + $homestay_unit['price'];
        }

        if ($request['unit_type'] == '3') {
            $requestData = [
                'id' => $new_id,
                'customer_id' => user()->id,
                'check_in' => $request['check_in'] . ' 06:00',
                'total_people' => $request['total_people'],
                'reservation_type' => '1'
            ];
        } else {
            $requestData = [
                'id' => $new_id,
                'customer_id' => user()->id,
                'check_in' => $request['check_in'] . ' 14:00',
                'total_people' => $request['total_people'],
                'reservation_type' => '1'
            ];
        }


        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addReservation = $this->reservationModel->add_reservation_api($requestData);

        $date = $request['check_in'];
        $date_array = array();
        for ($i = 0; $i < (int) $request['day_of_stay']; $i++) {
            $date = date('Y-m-d', strtotime($date));
            $date_array[] = $date;
            for ($j = 0; $j < count($homestay_units); $j++) {
                $addReservationDetail = $this->reservationHomestayUnitDetailModel->add_reservation_detail_api($homestay_id, $request['unit_type'], $homestay_units[$j]['unit_number'], $date, $new_id);
            }
            $date = date("Y-m-d", strtotime($date . ' + 1 days'));
        }

        if ($addReservation) {
            return redirect()->to(base_url('web/reservation/detail/' . $new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function createReservationEvent($homestay_id = null)
    {

        $request = $this->request->getPost();
        $date = $request['check_in'];
        for ($i = 0; $i < (int) $request['day_of_stay']; $i++) {
            $date = date('Y-m-d', strtotime($date));
            $date_array[] = $date;
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reseration_by_date($date)->getRowArray();
            if ($reservation_detail) {
                session()->setFlashdata('failed', date('d F Y', strtotime($date)));
                return redirect()->back()->withInput();
            }
            $date = date("Y-m-d", strtotime($date . ' + 1 days'));
        }
        $new_id = $this->reservationModel->get_new_id_api();

        $total_price = 0;

        $homestay_units = array();
        $homestay_unit_data = $this->homestayUnitModel->get_list_hu_api($homestay_id)->getResultArray();

        for ($i = 0; $i < count($homestay_unit_data); $i++) {
            $homestay_units[] = $homestay_unit_data[$i];
            $total_price = $total_price + $homestay_unit_data[$i]['price'];
        }
        $total_price = $total_price * $request['day_of_stay'] * 90 / 100;
        // dd($total_price);
        $deposit = $total_price * 20 / 100;

        $requestData = [
            'id' => $new_id,
            'customer_id' => user()->id,
            'check_in' => $request['check_in'] . ' 14:00',
            'total_people' => $request['total_people'],
            'total_price' => $total_price,
            'deposit' => $deposit,
            // 'reservation_finish_at' => Time::now(),
            'reservation_type' => '2',
            // 'status' => '0'
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addReservation = $this->reservationModel->add_reservation_event_api($requestData);

        $date = $request['check_in'];
        $date_array = array();
        for ($i = 0; $i < (int) $request['day_of_stay']; $i++) {
            $date = date('Y-m-d', strtotime($date));
            $date_array[] = $date;
            for ($j = 0; $j < count($homestay_units); $j++) {
                $addReservationDetail = $this->reservationHomestayUnitDetailModel->add_reservation_detail_api($homestay_id, $homestay_units[$j]['unit_type'], $homestay_units[$j]['unit_number'], $date, $new_id);
            }
            $date = date("Y-m-d", strtotime($date . ' + 1 days'));
        }

        $additionalAmenities = $this->homestayAdditionalAmenitiesModel->get_haa_for_event($homestay_id)->getResultArray();
        foreach ($additionalAmenities as $item) {
            $data = [
                'homestay_id' => $homestay_id,
                'additional_amenities_id' => $item['additional_amenities_id'],
                'reservation_id' => $new_id,
                'day_order' => '0',
                'person_order' => '0',
                'room_order' => '0',
                'total_order' => '1',
                'total_price' => '0',
            ];
            $addAdditionalAmenities = $this->reservationHomestayAdditionalAmenitiesDetailModel->add_detail_haa($data);
        }

        if ($addReservation) {
            return redirect()->to(base_url('web/reservation/detail/' . $new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function manualReservation($homestay_id = null)
    {
        $request = $this->request->getPost();

        $new_id = $this->reservationModel->get_new_id_api();

        $total_price = 0;

        $homestay_units = array();
        for ($i = 0; $i < count($request['unit_number']); $i++) {
            $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id, $request['unit_type'], $request['unit_number'][$i])->getRowArray();
            $homestay_units[] = $homestay_unit;
            $total_price = $total_price + $homestay_unit['price'];
        }

        if ($request['unit_type'] == '3') {
            $requestData = [
                'id' => $new_id,
                'check_in' => $request['check_in'] . ' 06:00',
                'total_people' => $request['total_people'],
                'total_price' => $total_price,
                'status' => 'Done'
            ];
        } else {
            $requestData = [
                'id' => $new_id,
                'check_in' => $request['check_in'] . ' 14:00',
                'total_people' => $request['total_people'],
                'total_price' => $total_price,
                'status' => 'Done'
            ];
        }


        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addReservation = $this->reservationModel->add_reservation_api($requestData);

        $date = $request['check_in'];
        $date_array = array();
        for ($i = 0; $i < (int) $request['day_of_stay']; $i++) {
            $date = date('Y-m-d', strtotime($date));
            $date_array[] = $date;
            for ($j = 0; $j < count($homestay_units); $j++) {
                $addReservationDetail = $this->reservationHomestayUnitDetailModel->add_reservation_detail_api($homestay_id, $request['unit_type'], $homestay_units[$j]['unit_number'], $date, $new_id);
            }
            $date = date("Y-m-d", strtotime($date . ' + 1 days'));
        }

        if ($addReservation) {
            return redirect()->to(base_url('dashboard/reservation/detail/' . $new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function detailReservation($id = null)
    {
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        $coin = $this->userModel->get_user_coin_by_id($reservation['customer_id'])->getRowArray();
        // dd($coin);
        // $coin = $this->userModel->get_user_coin_by_id($reservation['customer_id']);
        //         $coinQuery = $this->userModel->get_user_coin_by_id($reservation['customer_id']);
        // $coin = $coinQuery ? $coinQuery->getRowArray() : null;

        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        if (($reservation['canceled_at'] == null) && (($reservation['is_rejected'] == '0') || ($reservation['is_rejected'] == null))) {
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getRowArray();
        } else {
            $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($id)->getRowArray();
        }

        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];




        if (empty($reservation)) {
            return redirect()->to(base_url('web/reservation'));
        }

        if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
            $checkIsReservationCancel = $this->checkIsReservationCancel($reservation);
        }

                $this->reservationModel->update_status($reservation['id'], 'Full Pay Expired');
                $messageUser = 'Your full price payment has been expired for the reservation with ID ' . $id . ' at ' . $homestay['name'] . '. Your reservation has been canceled.';
                $messageOwner = 'Full price payment for reservation with ID ' . $id . ' from @' . $user['username'] . ' has been expired. The reservation has been canceled.';
                $this->notification->sendMessage($user, $messageUser);
                $this->notification->sendMessage($owner, $messageOwner);
                $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation['id'])->getResultArray();

                foreach ($reservation_detail as $reservationDetail) {
                    $this->reservationHomestayUnitDetailBackUpModel->add_reservation_detail_api($reservationDetail);
                }
                $this->reservationHomestayUnitDetailModel->delete_reserv_det_by_reserv_id($reservation['id']);
            }
        }

        if ($reservation['status'] == 'Full Pay Successful') {
            $checkIsReservationDone = $this->checkIsReservationDone($reservation);
        }
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();


        if (($reservation['canceled_at'] != null) || ($reservation['is_rejected'] == '1') || ($reservation['status'] == 'Payment Expired')) {
            $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($id)->getResultArray();
        } else {
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getResultArray();
        }

        $tpac_save = $reservation['total_price'] - $reservation['coin_use'];
        // dd($tpac_save);

        $homestay_id = array();
        $unit_type = array();
        $day_of_stay = array();
        $unit_number = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
            $unit_number[] = $reservation_detail[$i]['unit_number'];
            $homestay_id[] = $reservation_detail[$i]['homestay_id'];
            $unit_type[] = $reservation_detail[$i]['unit_type'];
        }
        $day_of_stay = array_unique($day_of_stay);
        $unit_number = array_values(array_unique($unit_number));
        $homestay_id = array_unique($homestay_id);
        $unit_type = array_unique($unit_type);

        $homestay_units = array();
        for ($j = 0; $j < count($unit_number); $j++) {
            $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id[0], $unit_type[0], $unit_number[$j])->getRowArray();
            $homestay_units[] = $homestay_unit;
        }

        for ($i = 0; $i < count($homestay_units); $i++) {
            $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $homestay_units[$i]['unit_type'], $homestay_units[$i]['unit_number'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $homestay_units[$i]['galleries'] = $galleries;
        }

        $check_out = date("Y-m-d 12:00:00", strtotime($reservation['check_in'] . ' + ' . count($day_of_stay) . ' days'));
        $reservation['check_out'] = $check_out;
        $homestay_data = $this->homestayModel->get_hs_by_id_api($homestay_id[0])->getRowArray();

        $homestay['id'] = $homestay_data['id'];
        $homestay['name'] = $homestay_data['name'];
        $homestay['phone'] = $homestay_data['phone'];
        if ($unit_type[0] == '1') {
            $homestay['unit_type'] = "Room";
        } elseif ($unit_type[0] == '2') {
            $homestay['unit_type'] = "Villa";
        } else {
            $homestay['unit_type'] = "Hall";
        }

        $reservation['day_of_stay'] = count($day_of_stay);

        $reservation_additional_amenities = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_haa_by_rid_api($homestay_id[0], $reservation['id'])->getResultArray();
        for ($i = 0; $i < count($reservation_additional_amenities); $i++) {
            $amenities = $this->homestayAdditionalAmenitiesModel->get_haa_by_id_api($reservation_additional_amenities[$i]['homestay_id'], $reservation_additional_amenities[$i]['additional_amenities_id'])->getRowArray();
            $reservation_additional_amenities[$i]['name'] = $amenities['name'];
            $reservation_additional_amenities[$i]['category'] = $amenities['category'];
            $reservation_additional_amenities[$i]['price'] = $amenities['price'];
            $reservation_additional_amenities[$i]['is_order_count_per_day'] = $amenities['is_order_count_per_day'];
            $reservation_additional_amenities[$i]['is_order_count_per_person'] = $amenities['is_order_count_per_person'];
            $reservation_additional_amenities[$i]['is_order_count_per_room'] = $amenities['is_order_count_per_room'];
            $reservation_additional_amenities[$i]['description'] = $amenities['description'];
            $reservation_additional_amenities[$i]['image_url'] = $amenities['image_url'];
            $reservation_additional_amenities[$i]['id'] = $reservation_additional_amenities[$i]['additional_amenities_id'];
        }

        // $price_after_coin=$reservation()
        $data = [
            'title' => 'Reservation',
            'reservation' => $reservation,
            'coin' => $coin,
            'tpac_save' => $tpac_save,
            'homestay' => $homestay,
            'homestay_unit' => $homestay_units,
            'reservation_additional_amenities' => $reservation_additional_amenities,
        ];
        // dd($data);

        return view('web/reservation_detail', $data);
    }



    public function getPackage($homestay_id = null, $reservation_id = null)
    {
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getResultArray();
        $day_of_stay = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
        }
        $day_of_stay = array_unique($day_of_stay);

        $package_detail = $this->packageDetailModel->get_pid_by_day($homestay_id, count($day_of_stay))->getResultArray();

        $package_id_available = array();
        for ($i = 0; $i < count($package_detail); $i++) {
            if ($package_detail[$i]['total_day'] <= count($day_of_stay)) {
                $package_id_available[] = $package_detail[$i]['package_id'];
            }
        }

        $packages = array();
        for ($i = 0; $i < count($package_id_available); $i++) {
            $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id_available[$i])->getRowArray();
            if (($package['homestay_id'] == $homestay_id) && ($package['is_custom'] == '0')) {
                foreach ($package_detail as $packageDetail) {
                    if ($packageDetail['package_id'] == $package['package_id']) {
                        $package['total_day'] = $packageDetail['total_day'];
                        $package['id'] = $package['package_id'];
                    }
                }
                $packages[] = $package;
            }
        }

        for ($i = 0; $i < count($packages); $i++) {
            $reservations = $this->reservationModel->get_reservation_by_cpid($homestay_id, $packages[$i]['package_id'])->getResultArray();
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
            $packages[$i]['avg_rating'] = $avg_rating;
        }


        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $data = [
            'title' => 'Reservation',
            'h_id' => $homestay_id,
            'reservation_id' => $reservation_id,
            'total_people' => $reservation['total_people'],
            'package' => $packages,
        ];

        return view('web/reservation_package', $data);
    }
    public function createCustomPackage($homestay_id = null, $reservation_id = null)
    {
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getResultArray();
        $day_of_stay = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
        }
        $day_of_stay = array_unique($day_of_stay);

        $package_new_id = $this->packageModel->get_new_id_api($homestay_id);

        date_default_timezone_set("Asia/Jakarta");
        $packageName = 'Custom by ' . user()->username . ' at ' . date("Y-m-d H:i");

        $requestData = [
            'package_id' => $package_new_id,
            'homestay_id' => $homestay_id,
            'name' => $packageName,
            'min_capacity' => 0,
            'price' => 0,
            'is_custom' => '1',
        ];

        $createPackage = $this->packageModel->add_package_api($requestData);

        $reservation = null;
        $addPackageonReservation = $this->reservationModel->add_package_api($reservation, $reservation_id, $homestay_id, $package_new_id);


        if ($createPackage) {
            return redirect()->to(base_url('web/reservation/package/customPackage/' . $reservation_id . "/"  . $homestay_id . "/" . $package_new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function createExtendPackage($homestay_id = null, $reservation_id = null, $package_id = null)
    {
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getResultArray();
        $day_of_stay = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
        }
        $day_of_stay = array_unique($day_of_stay);

        $package_new_id = $this->packageModel->get_new_id_api($homestay_id);

        $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();

        $package_day = $this->packageDayModel->get_pd_by_pacakage_id_api($homestay_id, $package_id)->getResultArray();

        $package_detail = $this->packageDetailModel->get_pd_by_pacakage_id_api($homestay_id, $package_id)->getResultArray();

        $package_service = $this->packageServiceDetailModel->get_list_service_by_id($homestay_id, $package_id)->getResultArray();
        for ($i = 0; $i < count($package_service); $i++) {
            unset($package_service[$i]['name']);
        }

        date_default_timezone_set("Asia/Jakarta");
        $packageName = $package['name'] . ' extend by ' . user()->username . ' at ' . date("Y-m-d H:i");

        $requestData = [
            'package_id' => $package_new_id,
            'homestay_id' => $homestay_id,
            'name' => $packageName,
            'min_capacity' => $package['min_capacity'],
            'price' => $package['price'],
            'is_custom' => '1',
        ];

        $createPackage = $this->packageModel->add_package_api($requestData);

        foreach ($package_day as $packageDay) {
            $packageDay['package_id'] = $package_new_id;
            $packageDay['homestay_id'] = $homestay_id;
            $packageDay['is_base_for_extend'] = "1";
            $createPackageDay = $this->packageDayModel->add_epd_api($packageDay);
        }

        foreach ($package_detail as $packageDetail) {
            $packageDetail['package_id'] = $package_new_id;
            $packageDetail['homestay_id'] = $homestay_id;
            $packageDetail['is_base_for_extend'] = "1";
            $createPackageDetail = $this->packageDetailModel->add_pd_api($packageDetail);
        }

        foreach ($package_service as $packageService) {
            if ($packageService['status'] == "1") {
                $packageService['package_id'] = $package_new_id;
                $packageService['homestay_id'] = $homestay_id;
                $packageService['is_base_for_extend'] = "1";
                unset($packageService['price']);
                unset($packageService['category']);
                $createPackageService = $this->packageServiceDetailModel->add_package_service($packageService);
            }
        }

        $reservation = null;
        $addPackageonReservation = $this->reservationModel->add_package_api($reservation, $reservation_id, $homestay_id, $package_new_id);


        if ($createPackage) {
            return redirect()->to(base_url('web/reservation/package/extendPackage/' . $reservation_id . '/' . $homestay_id . '/' . $package_new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function customPackage($reservation_id = null, $homestay_id = null, $package_id = null)
    {
        $data = $this->getPackageDetail($reservation_id, $homestay_id, $package_id);
        if (url_is('*customPackage*')) {
            $data['title'] = 'Custom Package';
        } else {
            $data['title'] = 'Extend Package';
        }
        return view('web/package_form', $data);
    }

    public function getPackageDetail($reservation_id = null, $homestay_id = null, $id = null)
    {
        $package = $this->packageModel->get_package_by_id_api($homestay_id, $id)->getRowArray();

        $package['gallery'] = [$package['brochure_url']];
        $package['id'] = $package['package_id'];

        $package_day = $this->packageDayModel->get_pd_by_pacakage_id_api($homestay_id, $id)->getResultArray();

        $list_activity = $this->packageDetailModel->get_pd_by_pacakage_id_api($homestay_id, $id)->getResultArray();
        for ($i = 0; $i < count($list_activity); $i++) {
            if (substr($list_activity[$i]['id_object'], 0, 1) === 'A') {
                $list_activity[$i]['type'] = "Attraction";
                $attraction = $this->attractionModel->get_at_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $attraction['name'];
                $list_activity[$i]['price_for_package'] = $attraction['price_for_package'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'C') {
                $list_activity[$i]['type'] = "Culinary";
                $culinaryPlace = $this->culinaryPlaceModel->get_cp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $culinaryPlace['name'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'S') {
                $list_activity[$i]['type'] = "Souvenir";
                $souvenirPlace = $this->souvenirPlaceModel->get_sp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $souvenirPlace['name'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'V') {
                $list_activity[$i]['type'] = "Service Provider";
                $serviceProvider = $this->serviceProviderModel->get_sv_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $serviceProvider['name'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'W') {
                $list_activity[$i]['type'] = "Worship";
                $worshipPlace = $this->worshipPlaceModel->get_wp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $worshipPlace['name'];
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'E') {
                $list_activity[$i]['type'] = "Event";
                $event = $this->eventModel->get_ev_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $event['name'];
                $list_activity[$i]['price_for_package'] = $event['ticket_price'];
            } else {
                $list_activity[$i]['type'] = "Homestay Activity";
                $homestayActivity = $this->homestayExclusiveActivityModel->get_hea_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                $list_activity[$i]['object_name'] = $homestayActivity['name'];
            }
        }

        $list_service = $this->packageServiceDetailModel->get_list_service_by_id($homestay_id, $id)->getResultArray();

        $reservation = $this->reservationModel->get_reservation_by_pid($reservation_id, $homestay_id, $id)->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation['id'])->getResultArray();
        $day_of_stay = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
        }
        $day_of_stay = array_unique($day_of_stay);

        if (url_is('*customPackage*')) {
            $total_people = $reservation['total_people'];
        } else {
            $total_people = $package['min_capacity'];
        }

        $data = [
            'package' => $package,
            'list_day' => $package_day,
            'list_activity' => $list_activity,
            'list_service' => $list_service,
            'reservation_id' => $reservation['id'],
            'total_people' => $total_people,
            'check_in' => $reservation['check_in'],
            'day_of_stay' => count($day_of_stay)
        ];

        if (url_is('*extendPackage*')) {
            $data['res_total_people'] = $reservation['total_people'];
        }

        return $data;
    }

    public function buyPackage($homestay_id = null, $reservation_id = null, $package_id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'total_people' => $request['total_people'],
        ];

        $check_package = $this->packageModel->check_package_api($homestay_id, $package_id)->getRowArray();
        if (empty($check_package)) {
            return redirect()->to(base_url('web/reservation'));
        }

        $addPackage = $this->reservationModel->add_package_api($requestData, $reservation_id, $homestay_id, $package_id);

        if ($addPackage) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function deletePackage($reservation_id = null)
    {
        $delPackage = $this->reservationModel->del_package_api($reservation_id);

        if ($delPackage) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function finishReservation($reservation_id = null, $deposit = null, $total_price = null, $coin = null)
    {
        // $finishPackage = $this->reservationModel->finish_reservation($reservation_id, $deposit, $total_price);
        $finishPackage = $this->reservationModel->finish_reservation($reservation_id, $deposit, $total_price, $coin);
        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        $messageUser = 'You have made a reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . '. Please wait for confirmation from the owner';
        $messageOwner = 'You have a new reservation with ID ' . $reservation_id . ' from @' . $user['username'] . '. Please confirm the reservation.';

        // $iduser = user()->id;
        $this->notification->sendMessage($user, $messageUser);
        $this->notification->sendMessage($owner, $messageOwner);

        if ($finishPackage) {
            $coinUser = $this->accountModel->calculate_coin(user()->id, $coin);
            if ($coinUser) {
                return redirect()->to(base_url('web'));
            }
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function setPackagePrice($reservation_id = null, $package_id = null)
    {
        $request = $this->request->getPost();

        $setPrice = $this->packageModel->set_price($request['price'], $package_id);
        $setTotalPrice = $this->reservationModel->set_total_price($request['hs_res_price'] + $request['price'], $reservation_id);

        if ($setPrice) {
            return redirect()->to(base_url('dashboard/reservation/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function confirmPackagePrice($reservation_id = null, $package_id = null)
    {
        $confirm = $this->reservationModel->confirm_package_price($reservation_id, $package_id);

        if ($confirm) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function confirmRefund($reservation_id = null)
    {
        $request = $this->request->getPost();

        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($reservation_id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        if ($request['is_refund_proof_correct'] == '1') {
            $messageUser = 'You have confirmed the refund payment proof at reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . ' your funds have been returned 50% of the deposit.';
            $messageOwner = 'Your refund proof at reservation with ID ' . $reservation_id . ' from @' . $user['username'] . ' has been confirmed.';
        } else {
            $messageUser = 'You have rejected the refund payment proof at reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . '. Please wait the homestay owner to upload the correct proof.';
            $messageOwner = 'Your refund proof at reservation with ID ' . $reservation_id . ' from @' . $user['username'] . ' has been rejected. Please check your refund payment proof and reupload the correct proof.';
        }

        $this->notification->sendMessage($user, $messageUser);
        $this->notification->sendMessage($owner, $messageOwner);
        $confirm = $this->reservationModel->confirm_refund($request, $reservation_id);

        if ($confirm) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function payDeposit($id = null)
    {
        $request = $this->request->getPost();

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

        $requestData = [
            'deposit_proof' => $gallery[0],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $payDeposit = $this->reservationModel->pay_deposit($requestData, $id);

        if ($payDeposit) {
            return redirect()->to(base_url('web/reservation/detail/' . $id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function payFull($id = null)
    {
        $request = $this->request->getPost();

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

        $requestData = [
            'full_paid_proof' => $gallery[0],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $payFull = $this->reservationModel->pay_full($requestData, $id);

        if ($payFull) {
            return redirect()->to(base_url('web/reservation/detail/' . $id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function cancelReservation($reservation_id = null)
    {
        date_default_timezone_set("Asia/Jakarta");
        $reservation['canceled_at'] = date("Y-m-d H:i");

        $reservation_data = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $date_refund = date("Y-m-d H:i", strtotime($reservation_data['check_in'] . ' - 1 days'));

        $reservationData = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $user = $this->userModel->get_user_by_id($reservationData['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        if (strtotime($reservation['canceled_at']) < strtotime($date_refund)) {
            $reservation['is_refund'] = '1';
            $messageUser = 'You have cancelled your reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . '. Please submit your bank account to get refund';
            $messageOwner = 'The reservation with ID ' . $reservation_id . ' from @' . $user['username'] . ' has been canceled. Please wait the customer to submit their bank account data.';
            $this->notification->sendMessage($user, $messageUser);
            $this->notification->sendMessage($owner, $messageOwner);
        } else {
            $reservation['is_refund'] = '0';
            $messageUser = 'You have cancelled your reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . '. You will not get a refund';
            $messageOwner = 'The reservation with ID ' . $reservation_id . ' from @' . $user['username'] . ' has been canceled.';
            $this->notification->sendMessage($user, $messageUser);
            $this->notification->sendMessage($owner, $messageOwner);
        }
        $reservation['cancelation_reason'] = '1';

        $cancel_reservation = $this->reservationModel->cancel_reservation($reservation, $reservation_id);

        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getResultArray();

        foreach ($reservation_detail as $reservationDetail) {
            $reservation_detail_backup = $this->reservationHomestayUnitDetailBackUpModel->add_reservation_detail_api($reservationDetail);
        }

        $delete_reservation_detail = $this->reservationHomestayUnitDetailModel->delete_reserv_det_by_reserv_id($reservation_id);



        if ($cancel_reservation) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function createBankAccount()
    {
        $request = $this->request->getPost();

        $reservation_id = $request['reservation_id'];

        unset($request['reservation_id']);

        $add = $this->userBankAccountModel->add_user_bank_account($request);

        if ($add) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function updateBankAccount($id = null)
    {
        $request = $this->request->getPost();
        $reservation_id = $request['reservation_id'];

        unset($request['reservation_id']);

        $update = $this->userBankAccountModel->update_user_bank_account($request, $id);

        if ($update) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function addAmenities()
    {
        $request = $this->request->getPost();
        $request['additional_amenities_id'] = substr($request['additional_amenities_id'], 0, 2);

        $add = $this->reservationHomestayAdditionalAmenitiesDetailModel->add_detail_haa($request);

        return redirect()->to(base_url('web/reservation/detail/' . $request['reservation_id']));
    }
    public function addActivity()
    {
        $request = $this->request->getPost();

        $reservation_homestay_activity = $this->reservationHomestayActivityDetailModel->get_activity_by_rid_api($request['reservation_id'])->getResultArray();

        $delete = $this->reservationHomestayActivityDetailModel->del_activity_by_rid_api($request['reservation_id']);

        if (isset($request['activity_id'])) {
            foreach ($request['activity_id'] as $activity_id) {
                $add = $this->reservationHomestayActivityDetailModel->add_detail_res_act($request['homestay_id'], $request['reservation_id'], $activity_id);
            }
        }

        return redirect()->to(base_url('web/reservation/detail/' . $request['reservation_id']));
    }

    public function addReview($reservation_id = null)
    {
        $request = $this->request->getPost();

        $addRating = $this->reservationModel->add_rating($request, $reservation_id);
        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $totalprice = $reservation['total_price'];
        $coin = $totalprice * 0.05;

        $bonusCoin = $this->reservationModel->bonus_coin($reservation_id, $coin);
        $coinUser = $this->accountModel->add_coin(user()->id, $coin);

        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        if ($addRating && $bonusCoin && $coinUser) {
            $messageUser = 'You have give rating and review at reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . '. Thank you for your feedback! You got ' . $coin . ' coin as a bonus for your feedback!';
            // $messageOwner = 'You have rejected a reservation with ID ' . $reservation_id . ' from @' . $user['username'] . '.';
            $this->notification->sendMessage($user, $messageUser);
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }

        // $this->notification->sendMessage($owner, $messageOwner);
    }
    //xxx
    public function index()
    {

        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $id_reservation1 = $this->reservationHomestayUnitDetailModel->get_reservation_by_hs_api($homestay['id'])->getResultArray();
        $id_reservation2 = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_hs_api($homestay['id'])->getResultArray();

        $id_reservation = array_merge($id_reservation1, $id_reservation2);

        $id = array();

        for ($i = 0; $i < count($id_reservation); $i++) {
            $id[$i] = $id_reservation[$i]['reservation_id'];
        }

        rsort($id);

        $nid = array();

        foreach ($id as $key => $value) {
            $nid[$key] = $value;
        }

        $reservations = array();
        for ($i = 0; $i < count($nid); $i++) {
            $reservation = $this->reservationModel->get_reservation_by_id($nid[$i])->getRowArray();
            if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
                $checkIsReservationCancel = $this->checkIsReservationCancel($reservation);
            }
            if ($reservation['status'] == 'Payment Successful') {
                $checkIsReservationDone = $this->checkIsReservationDone($reservation);
            }
            $reservation = $this->reservationModel->get_reservation_by_id($nid[$i])->getRowArray();
            $reservations[] = $reservation;
        }

        $data = [
            'title' => 'Reservation',
            'data' => $reservations,
        ];

        return view('owner/reservation_list', $data);
    }
    public function show($id = null)
    {

        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        // dd($id) ;
        if ($reservation['customer_id'] == null) {
            $coin['total_coin'] = 0;
        } else {
            $coin = $this->userModel->get_user_coin_by_id($reservation['customer_id'])->getRowArray();
            // dd($coin);
        }

        if (empty($reservation)) {
            return redirect()->to(base_url('dashboard/reservation'));
        }

        if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
            $checkIsReservationCancel = $this->checkIsReservationCancel($reservation);
        }
        if ($reservation['status'] == 'Payment Successful') {
            $checkIsReservationDone = $this->checkIsReservationDone($reservation);
        }
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();

        if (($reservation['canceled_at'] != null) || ($reservation['is_rejected'] == '1')) {
            $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($id)->getResultArray();
        } else {
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getResultArray();
        }

        $homestay_id = array();
        $unit_type = array();
        $day_of_stay = array();
        $unit_number = array();
        for ($i = 0; $i < count($reservation_detail); $i++) {
            $day_of_stay[] = $reservation_detail[$i]['date'];
            $unit_number[] = $reservation_detail[$i]['unit_number'];
            $homestay_id[] = $reservation_detail[$i]['homestay_id'];
            $unit_type[] = $reservation_detail[$i]['unit_type'];
        }
        $day_of_stay = array_unique($day_of_stay);
        $unit_number = array_values(array_unique($unit_number));
        $homestay_id = array_unique($homestay_id);
        $unit_type = array_unique($unit_type);

        $homestay_units = array();
        for ($j = 0; $j < count($unit_number); $j++) {
            $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id[0], $unit_type[0], $unit_number[$j])->getRowArray();
            $homestay_units[] = $homestay_unit;
        }

        for ($i = 0; $i < count($homestay_units); $i++) {
            $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $homestay_units[$i]['unit_type'], $homestay_units[$i]['unit_number'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $homestay_units[$i]['galleries'] = $galleries;
        }

        $check_out = date("Y-m-d 12:00:00", strtotime($reservation['check_in'] . ' + ' . count($day_of_stay) . ' days'));
        $reservation['check_out'] = $check_out;

        $homestay_data = $this->homestayModel->get_hs_by_id_api($homestay_id[0])->getRowArray();

        $homestay['id'] = $homestay_data['id'];
        $homestay['name'] = $homestay_data['name'];
        $homestay['phone'] = $homestay_data['phone'];
        if ($unit_type[0] == '1') {
            $homestay['unit_type'] = "Room";
        } elseif ($unit_type[0] == '2') {
            $homestay['unit_type'] = "Villa";
        } else {
            $homestay['unit_type'] = "Hall";
        }

        $reservation['day_of_stay'] = count($day_of_stay);

        $reservation_additional_amenities = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_haa_by_rid_api($homestay_id[0], $reservation['id'])->getResultArray();
        for ($i = 0; $i < count($reservation_additional_amenities); $i++) {
            $amenities = $this->homestayAdditionalAmenitiesModel->get_haa_by_id_api($reservation_additional_amenities[$i]['homestay_id'], $reservation_additional_amenities[$i]['additional_amenities_id'])->getRowArray();
            $reservation_additional_amenities[$i]['name'] = $amenities['name'];
            $reservation_additional_amenities[$i]['category'] = $amenities['category'];
            $reservation_additional_amenities[$i]['price'] = $amenities['price'];
            $reservation_additional_amenities[$i]['is_order_count_per_day'] = $amenities['is_order_count_per_day'];
            $reservation_additional_amenities[$i]['is_order_count_per_person'] = $amenities['is_order_count_per_person'];
            $reservation_additional_amenities[$i]['is_order_count_per_room'] = $amenities['is_order_count_per_room'];
            $reservation_additional_amenities[$i]['description'] = $amenities['description'];
            $reservation_additional_amenities[$i]['image_url'] = $amenities['image_url'];
            $reservation_additional_amenities[$i]['id'] = $reservation_additional_amenities[$i]['additional_amenities_id'];
        }

        $data = [
            'title' => 'Reservation',
            'reservation' => $reservation,
            'homestay' => $homestay,
            'homestay_unit' => $homestay_units,
            'coin' => $coin,
            'reservation_additional_amenities' => $reservation_additional_amenities,
        ];

        if (!empty($reservation['package_id'])) {
            $package = $this->packageModel->get_package_by_id_api($reservation['homestay_id'], $reservation['package_id'])->getRowArray();
            $data['package'] = $package;
            $data2 = $this->getPackageDetail($reservation['id'], $reservation['homestay_id'], $reservation['package_id']);

            $data = array_merge($data, $data2);
        }
        return view('owner/reservation_detail', $data);
    }

    public function refundReservation($reservation_id = null)
    {
        $request = $this->request->getPost();

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

        $requestData = [
            'refund_proof' => $gallery[0],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $payDeposit = $this->reservationModel->refund_reservation($requestData, $reservation_id);

        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($reservation_id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        if ($payDeposit) {
            $messageUser = 'Your deposit refund at reservation with ID ' . $reservation_id . ' at ' . $homestay['name'] . ' has been paid. Please check refund proof at reservation detail page.';
            $messageOwner = 'Upload deposit refund proof at reservation with ID ' . $reservation_id . ' from @' . $user['username'] . ' has been succeessful. Please wait the confirmation from customer.';
            $this->notification->sendMessage($user, $messageUser);
            $this->notification->sendMessage($owner, $messageOwner);
            return redirect()->to(base_url('dashboard/reservation/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function create() {}
    public function update($id = null) {}
    public function checkIsReservationCancel($reservation = null)
    {
        date_default_timezone_set("Asia/Jakarta");
        $dateNow = date("Y-m-d H:i");

        $depositDeadline = date("d F Y, H:i", strtotime($reservation['check_in'] . ' - 2 days'));
        $fullPayDeadline = date("d F Y, 18:00", strtotime($reservation['check_in']));


        if ((strtotime($dateNow) > strtotime($depositDeadline)) && (($reservation['status'] == null) || ($reservation['status'] == '0') || ($reservation['status'] == '1')) && ($reservation['canceled_at'] == null)) {
            $cancelReservation['canceled_at'] = $dateNow;
            $cancelReservation['cancelation_reason'] = '2';
            $cancelReservation['is_refund'] = '0';
            $cancel_reservation = $this->reservationModel->cancel_reservation($cancelReservation, $reservation['id']);
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation['id'])->getResultArray();

            foreach ($reservation_detail as $reservationDetail) {
                $reservation_detail_backup = $this->reservationHomestayUnitDetailBackUpModel->add_reservation_detail_api($reservationDetail);
            }
            $delete_reservation_detail = $this->reservationHomestayUnitDetailModel->delete_reserv_det_by_reserv_id($reservation['id']);
        } else if ((strtotime($dateNow) > strtotime($fullPayDeadline)) && (($reservation['status'] == 'Deposit Successful') || ($reservation['status'] == 'Full Pay Pending')) && ($reservation['canceled_at'] == null)) {
            $cancelReservation['canceled_at'] = $dateNow;
            $cancelReservation['cancelation_reason'] = '3';
            $cancelReservation['is_refund'] = '0';
            $cancel_reservation = $this->reservationModel->cancel_reservation($cancelReservation, $reservation['id']);
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation['id'])->getResultArray();

            foreach ($reservation_detail as $reservationDetail) {
                $reservation_detail_backup = $this->reservationHomestayUnitDetailBackUpModel->add_reservation_detail_api($reservationDetail);
            }
            $delete_reservation_detail = $this->reservationHomestayUnitDetailModel->delete_reserv_det_by_reserv_id($reservation['id']);
        }
    }

    public function new()
    {

        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $data = [
            'title' => 'Add Reservation',
            'homestayid' => $homestay['id'],
        ];
        return view('owner/reservation_form', $data);
    }

    public function checkIsReservationDone($reservation = null)
    {

        $stayInDates = $this->reservationHomestayUnitDetailModel->get_stay_in_dates($reservation['id'])->getResultArray();

        $day_of_stay = count($stayInDates);

        $checkOutDate = strtotime($reservation['check_in'] . ' + ' . $day_of_stay . ' days');

        $currentDate = time();

        if ($currentDate > $checkOutDate) {
            $this->reservationModel->update_status($reservation['id'], 'Done');
        }
    }

}
