<?php

namespace App\Controllers\Web\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Response;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\PackageModel;
use App\Models\PackageDayModel;
use App\Models\PackageDetailModel;
use App\Models\PackageServiceDetailModel;
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
use App\Models\Reservation\ReservationPackageDetailModel;
use App\Models\AccountModel;
use App\Controllers\Api\Notification;
use App\Models\AttractionModel;
use App\Models\Culinary\CulinaryPlaceModel;
use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\ServiceProviderModel;
use App\Models\Worship\WorshipPlaceModel;
use App\Models\EventModel;
use App\Models\UserBankAccountModel;
use Myth\Auth\Models\UserModel;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

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
    protected $reservationPackageDetailModel;
    protected $notification;

    protected $attractionModel;
    protected $culinaryPlaceModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $worshipPlaceModel;
    protected $eventModel;
    protected UserBankAccountModel $userBankAccountModel;
    protected $userModel;
    private ?GuzzleClient $guzzleClient = null;

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
        $this->reservationPackageDetailModel = new ReservationPackageDetailModel();
        $this->notification = new Notification();

        $this->attractionModel = new AttractionModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
        $this->eventModel = new EventModel();
        $this->userBankAccountModel = new UserBankAccountModel();
        $this->userModel = new UserModel();
        $this->guzzleClient = new GuzzleClient();
    }

    public function listReservation()
    {
        $reservations = $this->reservationModel->get_list_reservation_by_cus_id(user()->id)->getResultArray();

        foreach ($reservations as $reservation) {
            if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
                $this->checkIsReservationCancel($reservation);
            }
            if ($reservation['status'] == 'Full Pay Successful') {
                $this->checkIsReservationDone($reservation);
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
        /** @var Response $response */
        $response = $client->get($url);

        if ($response->getStatusCode() === 200) {
            $result = json_decode($response->getBody() ?? '', true);
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

    public function create($homestay_id = null)
    {
        $request = $this->request->getPost();

        if ($homestay_id === null) {
            $homestay_id = $request['homestay_id'];
        }

        // Generate new reservation ID
        $new_id = $this->reservationModel->get_new_id_api();

        // Calculate total price and gather homestay units
        $total_price = 0;
        $homestay_units = [];
        if (isset($request['unit_number']) && is_array($request['unit_number'])) {
            for ($i = 0; $i < count($request['unit_number']); $i++) {
                $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id, $request['unit_type'], $request['unit_number'][$i])->getRowArray();
                if ($homestay_unit) {
                    $homestay_units[] = $homestay_unit;
                    $total_price += $homestay_unit['price'];
                }
            }
        }

        $total_price *= (int)$request['day_of_stay'];

        // Prepare reservation data
        $check_in_time = ($request['unit_type'] == '3') ? '06:00' : '14:00';
        $requestData = [
            'id' => $new_id,
            'customer_id' => user()->id,
            'check_in' => $request['check_in'] . ' ' . $check_in_time,
            'total_people' => $request['total_people'],
            'reservation_type' => '1',
            'total_price' => $total_price,
            'request_date' => Time::now('Asia/Jakarta', 'en_US')
        ];

        // Insert reservation
        $addReservation = $this->reservationModel->insert($requestData, false);

        if ($addReservation) {
            $date = $request['check_in'];
            for ($i = 0; $i < (int)$request['day_of_stay']; $i++) {
                $current_date = date('Y-m-d', strtotime($date . " +{$i} days"));
                foreach ($homestay_units as $unit) {
                    $detailData = [
                        'reservation_id' => $new_id,
                        'homestay_id' => $homestay_id,
                        'unit_type' => $request['unit_type'],
                        'unit_number' => $unit['unit_number'],
                        'date' => $current_date
                    ];
                    if (!$this->reservationHomestayUnitDetailModel->insert($detailData, false)) {
                        $error = $this->reservationHomestayUnitDetailModel->errors();
                        log_message('error', 'Failed to insert reservation detail: ' . print_r($error, true));
                        session()->setFlashdata('error', 'Failed to create reservation detail. DB Error: ' . json_encode($error));
                        return redirect()->back()->withInput();
                    }
                }
            }
            // Redirect to the detail page
            return redirect()->to(base_url('web/reservation/detail/' . $new_id));
        } else {
            $error = $this->reservationModel->errors();
            log_message('error', 'Failed to insert reservation: ' . print_r($error, true));
            session()->setFlashdata('error', 'Failed to create reservation. DB Error: ' . json_encode($error));
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

        if ($addReservation) {
            $date = $request['check_in'];
            for ($i = 0; $i < (int) $request['day_of_stay']; $i++) {
                $date = date('Y-m-d', strtotime($date));
                for ($j = 0; $j < count($homestay_units); $j++) {
                    $this->reservationHomestayUnitDetailModel->add_reservation_detail_api($homestay_id, $homestay_units[$j]['unit_type'], $homestay_units[$j]['unit_number'], $date, $new_id);
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
                $this->reservationHomestayAdditionalAmenitiesDetailModel->add_detail_haa($data);
            }
            return redirect()->to(base_url('web/reservation/detail/' . $new_id));
        } else {
            $error = $this->reservationModel->db->error();
            session()->setFlashdata('error', $error['message']);
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
            return redirect()->to(base_url('dashboard/Reservation/detail/' . $new_id));
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function detailReservation($id = null)
    {
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        if (empty($reservation)) {
            die('Debug: Reservation data is not found for id: ' . $id);
        }

        $coin = $this->userModel->get_user_coin_by_id($reservation['customer_id'])->getRowArray();
        if (empty($coin)) {
            $coin = ['total_coin' => 0];
        }

        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        if (empty($user)) {
            die('Debug: User not found for customer_id: ' . $reservation['customer_id']);
        }

        $reservation_detail_for_homestay = null;
        if (($reservation['canceled_at'] == null) && (($reservation['is_rejected'] == '0') || ($reservation['is_rejected'] == null))) {
            $reservation_detail_for_homestay = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getRowArray();
        } else {
            $reservation_detail_for_homestay = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($id)->getRowArray();
        }

        if (empty($reservation_detail_for_homestay)) {
            die('Debug: Reservation detail not found for id: ' . $id);
        }

        $homestay_data = $this->homestayModel->get_hs_by_id_api($reservation_detail_for_homestay['homestay_id'])->getRowArray();
        if (empty($homestay_data)) {
            die('Debug: Homestay data not found for homestay_id: ' . $reservation_detail_for_homestay['homestay_id']);
        }

        $owner = $this->userModel->get_user_by_id($homestay_data['owner'])->getRowArray();
        if (empty($owner)) {
            die('Debug: Owner not found for owner_id: ' . $homestay_data['owner']);
        }

        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'] ?? 'User';
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'] ?? 'Owner';

        if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
            $this->checkIsReservationCancel($reservation);
        }

        if ($reservation['status'] == 'Full Pay Successful') {
            $this->checkIsReservationDone($reservation);
        }
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();


        if (($reservation['canceled_at'] != null) || ($reservation['is_rejected'] == '1') || ($reservation['status'] == 'Payment Expired')) {
            $reservation_detail = $this->reservationHomestayUnitDetailBackUpModel->get_reservation_by_id($id)->getResultArray();
        } else {
            $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getResultArray();
        }

        $tpac_save = $reservation['total_price'] - $reservation['coin_use'];

        $homestay_id = array();
        $unit_type = array();
        $day_of_stay = array();
        $unit_number = array();
        foreach ($reservation_detail as $detail) {
            $day_of_stay[] = $detail['date'];
            $unit_number[] = $detail['unit_number'];
            $homestay_id[] = $detail['homestay_id'];
            $unit_type[] = $detail['unit_type'];
        }
        $day_of_stay = array_unique($day_of_stay);
        $unit_number = array_values(array_unique($unit_number));
        $homestay_id = array_unique($homestay_id);
        $unit_type = array_unique($unit_type);

        $homestay_units = array();
        if (!empty($homestay_id) && !empty($unit_type)) {
            for ($j = 0; $j < count($unit_number); $j++) {
                $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id[0], $unit_type[0], $unit_number[$j])->getRowArray();
                $homestay_units[] = $homestay_unit;
            }
        }

        for ($i = 0; $i < count($homestay_units); $i++) {
            if (isset($homestay_units[$i]['unit_type']) && isset($homestay_units[$i]['unit_number'])) {
                $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id[0], $homestay_units[$i]['unit_type'], $homestay_units[$i]['unit_number'])->getResultArray();
                $galleries = array();
                foreach ($list_gallery as $gallery) {
                    $galleries[] = $gallery['url'];
                }
                $homestay_units[$i]['galleries'] = $galleries;
            }
        }

        $check_out = date("Y-m-d 12:00:00", strtotime($reservation['check_in'] . ' + ' . count($day_of_stay) . ' days'));
        $reservation['check_out'] = $check_out;

        $homestay['id'] = $homestay_data['id'];
        $homestay['name'] = $homestay_data['name'];
        $homestay['phone'] = $homestay_data['phone'];

        if (!empty($unit_type)) {
            if ($unit_type[0] == '1') {
                $homestay['unit_type'] = "Room";
            } elseif ($unit_type[0] == '2') {
                $homestay['unit_type'] = "Villa";
            } else {
                $homestay['unit_type'] = "Hall";
            }
        }

        $reservation['day_of_stay'] = count($day_of_stay);

        $reservation_additional_amenities = [];
        if (!empty($homestay_id)) {
            $reservation_additional_amenities = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_haa_by_rid_api($homestay_id[0], $reservation['id'])->getResultArray();
        }

        for ($i = 0; $i < count($reservation_additional_amenities); $i++) {
            $amenities = $this->homestayAdditionalAmenitiesModel->get_haa_by_id_api($reservation_additional_amenities[$i]['homestay_id'], $reservation_additional_amenities[$i]['additional_amenities_id'])->getRowArray();
            if ($amenities) {
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
        }

        $packages = [];
        $reservation_package = $this->reservationPackageDetailModel->get_packages_by_rid($id);
        if (!empty($reservation_package)) {
            foreach ($reservation_package as $rp) {
                $package_id = $rp['package_id'];
                $package_data = $this->packageModel->get_package_by_id_api($homestay_id[0], $package_id)->getRowArray();
                if ($package_data) {
                    $package_data['id'] = $package_data['package_id'];
                    $package_data['package_order'] = $rp['package_order'];
                    $package_data['package_total_price'] = $rp['package_total_price'];

                    $package_day = $this->packageDayModel->get_total_day_by_package_id($homestay_id[0], $package_id)->getRowArray();
                    $package_data['total_day'] = $package_day['total_day'] ?? 0;

                    $packages[] = $package_data;
                }
            }
        }

        // --- Get available packages for this homestay ---
        $available_packages = [];
        if (!empty($homestay_id)) {
            $package_list = $this->packageModel->list_by_homestay_api($homestay_id[0])->getResultArray();
            foreach ($package_list as $pkg) {
                // Only show non-custom packages that are not already in the reservation
                $is_added = false;
                foreach ($packages as $added_package) {
                    if ($added_package['package_id'] === $pkg['package_id']) {
                        $is_added = true;
                        break;
                    }
                }

                if ($pkg['is_custom'] == '0' && !$is_added) {
                    $package_day_info = $this->packageDayModel->get_total_day_by_package_id($homestay_id[0], $pkg['package_id'])->getRowArray();
                    $pkg['total_day'] = $package_day_info['total_day'] ?? 0;
                    $pkg['id'] = $pkg['package_id'];
                    $available_packages[] = $pkg;
                }
            }
        }

        // --- Fetch Currency Conversion Rates for Popup Checkout ---
        $rates = [];
        $apiKey = env('exchangerate.apiKey');
        if ($apiKey) {
            try {
                $response = $this->guzzleClient->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/IDR");
                $body = json_decode($response->getBody()->getContents(), true);
                if ($body['result'] === 'success') {
                    $rates = $body['conversion_rates'];
                }
            } catch (RequestException $e) {
                log_message('error', 'ExchangeRate-API Exception: ' . $e->getMessage());
            }
        }
        // --- End Fetch ---

        $data = [
            'title' => 'Reservation',
            'reservation' => $reservation,
            'coin' => $coin,
            'tpac_save' => $tpac_save,
            'homestay' => $homestay,
            'homestay_unit' => $homestay_units,
            'reservation_additional_amenities' => $reservation_additional_amenities,
            'packages' => $packages,
            'available_packages' => $available_packages,
            'idr_to_usd_rate'  => (float)env('IDR_TO_USD_RATE'),
            'rates'            => $rates
        ];
        return view('web/reservation_detail', $data);
    }

    public function update($id = null) {}
    public function delete($id = null) {}

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
                if (isset($reservation['rating']) && $reservation['rating'] != null) {
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

        $packageData = [
            'reservation_id' => $reservation_id,
            'package_id' => $package_new_id,
            'package_order' => 1, // Default order for custom package
        ];
        $this->reservationPackageDetailModel->add_package($packageData);


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

        $packageData = [
            'reservation_id' => $reservation_id,
            'package_id' => $package_new_id,
            'package_order' => 1, // Default order for extended package
        ];
        $this->reservationPackageDetailModel->add_package($packageData);

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
                if ($attraction) {
                    $list_activity[$i]['object_name'] = $attraction['name'];
                    $list_activity[$i]['price_for_package'] = $attraction['price_for_package'];
                } else {
                    $list_activity[$i]['object_name'] = 'Attraction not found';
                    $list_activity[$i]['price_for_package'] = 0;
                }
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'C') {
                $list_activity[$i]['type'] = "Culinary";
                $culinaryPlace = $this->culinaryPlaceModel->get_cp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($culinaryPlace) {
                    $list_activity[$i]['object_name'] = $culinaryPlace['name'];
                } else {
                    $list_activity[$i]['object_name'] = 'Culinary not found';
                }
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'S') {
                $list_activity[$i]['type'] = "Souvenir";
                $souvenirPlace = $this->souvenirPlaceModel->get_sp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($souvenirPlace) {
                    $list_activity[$i]['object_name'] = $souvenirPlace['name'];
                } else {
                    $list_activity[$i]['object_name'] = 'Souvenir not found';
                }
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'V') {
                $list_activity[$i]['type'] = "Service Provider";
                $serviceProvider = $this->serviceProviderModel->get_sv_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($serviceProvider) {
                    $list_activity[$i]['object_name'] = $serviceProvider['name'];
                } else {
                    $list_activity[$i]['object_name'] = 'Service Provider not found';
                }
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'W') {
                $list_activity[$i]['type'] = "Worship";
                $worshipPlace = $this->worshipPlaceModel->get_wp_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($worshipPlace) {
                    $list_activity[$i]['object_name'] = $worshipPlace['name'];
                } else {
                    $list_activity[$i]['object_name'] = 'Worship Place not found';
                }
            } elseif (substr($list_activity[$i]['id_object'], 0, 1) === 'E') {
                $list_activity[$i]['type'] = "Event";
                $event = $this->eventModel->get_ev_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($event) {
                    $list_activity[$i]['object_name'] = $event['name'];
                    $list_activity[$i]['price_for_package'] = $event['ticket_price'];
                } else {
                    $list_activity[$i]['object_name'] = 'Event not found';
                    $list_activity[$i]['price_for_package'] = 0;
                }
            } else {
                $list_activity[$i]['type'] = "Homestay Activity";
                $homestayActivity = $this->homestayExclusiveActivityModel->get_hea_by_id_api($list_activity[$i]['id_object'])->getRowArray();
                if ($homestayActivity) {
                    $list_activity[$i]['object_name'] = $homestayActivity['name'];
                } else {
                    $list_activity[$i]['object_name'] = 'Homestay Activity not found';
                }
            }
        }

        $list_service = $this->packageServiceDetailModel->get_list_service_by_id($homestay_id, $id)->getResultArray();

        $reservation = $this->reservationModel->get_reservation_by_id($reservation_id)->getRowArray();
        if (empty($reservation)) {
            // If reservation is not found, it's a bad request.
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Reservation with ID: {$reservation_id} not found.");
        }

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

        $package = $this->packageModel->get_package_by_id_api($homestay_id, $package_id)->getRowArray();
        if (empty($package)) {
            return redirect()->to(base_url('web/reservation'));
        }

        $total_people = $request['total_people'] ?? 0;
        $min_capacity = $package['min_capacity'] ?? 1;
        $price = $package['price'] ?? 0;

        $packageOrder = 1; // Default to 1
        if ($min_capacity > 0 && $total_people > 0) {
            $packageOrder = $total_people / $min_capacity;
            if ($packageOrder < 1) {
                $packageOrder = 1;
            } elseif (($total_people % $min_capacity <= $min_capacity / 2) && ($total_people % $min_capacity > 0)) {
                $packageOrder = floor($packageOrder) + 0.5;
            } elseif ($total_people % $min_capacity > $min_capacity / 2) {
                // Use ceil for simplicity if it's over half
                $packageOrder = ceil($packageOrder);
            }
        }

        $package_total_price = $packageOrder * $price;

        $packageData = [
            'reservation_id' => $reservation_id,
            'package_id' => $package_id,
            'package_order' => $packageOrder,
            'package_total_price' => $package_total_price
        ];
        $addPackage = $this->reservationPackageDetailModel->add_package($packageData);

        // --- DEBUGGING ---
        if ($addPackage) {
            // Recalculate total price after adding a package
            $this->updateReservationTotalPrice($reservation_id);
            session()->setFlashdata('success', 'Package has been added to your reservation.');
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            // Get database error
            $error = $this->reservationPackageDetailModel->errors();
            // Log the detailed error and data
            log_message('error', '[BUY_PACKAGE_FAILED] Data: ' . json_encode($packageData) . ' | DB Error: ' . json_encode($error));

            // Set a flash message for the user
            session()->setFlashdata('error', 'Failed to add package. Please try again. ' . (ENVIRONMENT !== 'production' ? json_encode($error) : ''));

            return redirect()->back()->withInput();
        }
    }

    public function deletePackage($reservation_id = null)
    {
        // We need to know which package to delete.
        // Assuming one package per reservation for now.
        $reservation_package = $this->reservationPackageDetailModel->get_packages_by_rid($reservation_id);
        if (empty($reservation_package)) {
            return redirect()->back()->with('error', 'No package to delete.');
        }
        $delPackage = $this->reservationPackageDetailModel->delete_package($reservation_id, $reservation_package[0]['package_id']);

        if ($delPackage) {
            // Recalculate total price after deleting a package
            $this->updateReservationTotalPrice($reservation_id);
            return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
        } else {
            session()->setFlashdata('error', 'Failed to delete package.');
            return redirect()->back();
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
                return redirect()->to(base_url('web/reservation'));
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

    public function addAccountRefund()
    {
        $request = $this->request->getPost();
        $reservationId = $request['reservation_id'];
        $accountRefund = $request['account_refund'];

        $updateData = ['account_refund' => $accountRefund];
        $updated = $this->reservationModel->update($reservationId, $updateData);

        if ($updated) {
            return redirect()->to(base_url('web/reservation/detail/' . $reservationId))->with('success', 'Bank account for refund has been saved.');
        }
        return redirect()->back()->with('error', 'Failed to save bank account.');
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

        if (!isset($request['additional_amenities_id'])) {
            session()->setFlashdata('error', 'Please select an amenity.');
            return redirect()->back()->withInput();
        }

        $data = [
            'reservation_id' => $request['reservation_id'],
            'homestay_id' => $request['homestay_id'],
            'additional_amenities_id' => $request['additional_amenities_id'],
            'total_order' => $request['total_order'] ?? 1,
            'total_price' => $request['total_price'] ?? 0,
            'day_order' => $request['day_order'] ?? 0,
            'person_order' => $request['person_order'] ?? 0,
            'room_order' => $request['room_order'] ?? 0,
        ];

        $add = $this->reservationHomestayAdditionalAmenitiesDetailModel->add_detail_haa($data);

        $this->updateReservationTotalPrice($request['reservation_id']);

        if ($add) {
            session()->setFlashdata('success', 'Additional amenity added successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to add additional amenity.');
        }

        return redirect()->to(base_url('web/reservation/detail/' . $request['reservation_id']));
    }

    public function updateAmenities()
    {
        $request = $this->request->getPost();
        $reservationId = $request['reservation_id'];
        $amenityId = $request['additional_amenities_id'];

        $data = [
            'total_order' => $request['total_order'] ?? 1,
            'total_price' => $request['total_price'] ?? 0,
            'day_order' => $request['day_order'] ?? 0,
            'person_order' => $request['person_order'] ?? 0,
            'room_order' => $request['room_order'] ?? 0,
        ];

        $update = $this->reservationHomestayAdditionalAmenitiesDetailModel->update_detail_haa($reservationId, $amenityId, $data);

        $this->updateReservationTotalPrice($reservationId);

        if ($update) {
            session()->setFlashdata('success', 'Additional amenity updated successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to update additional amenity.');
        }

        return redirect()->to(base_url('web/reservation/detail/' . $reservationId));
    }

    public function deleteAmenities($reservation_id = null, $homestay_id = null, $amenity_id = null)
    {
        $delete = $this->reservationHomestayAdditionalAmenitiesDetailModel->del_haa_by_id_api($homestay_id, $amenity_id, $reservation_id);

        $this->updateReservationTotalPrice($reservation_id);

        if ($delete) {
            session()->setFlashdata('success', 'Additional amenity removed successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to remove additional amenity.');
        }

        return redirect()->to(base_url('web/reservation/detail/' . $reservation_id));
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

    public function extendReservation($id = null)
    {
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        if (empty($reservation)) {
            return redirect()->to(base_url('web/reservation'))->with('error', 'Reservation not found.');
        }

        // Get current reservation details
        $reservation_details = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getResultArray();
        $homestay_id = $reservation_details[0]['homestay_id'] ?? null;
        $unit_type = $reservation_details[0]['unit_type'] ?? null;

        $unit_numbers = array_unique(array_column($reservation_details, 'unit_number'));
        $existing_dates = array_unique(array_column($reservation_details, 'date'));
        $day_of_stay = count($existing_dates);
        $check_out = date("Y-m-d", strtotime($reservation['check_in'] . ' + ' . $day_of_stay . ' days'));

        $data = [
            'title' => 'Extend Reservation',
            'reservation' => $reservation,
            'homestay_id' => $homestay_id,
            'unit_type' => $unit_type,
            'unit_numbers' => $unit_numbers,
            'day_of_stay' => $day_of_stay,
            'check_out' => $check_out,
        ];

        return view('web/reservation_extend_form', $data);
    }

    public function processExtendReservation($id = null)
    {
        $request = $this->request->getPost();
        $extend_days = (int)$request['extend_day'];

        if ($extend_days <= 0) {
            return redirect()->back()->with('error', 'Extend day must be a positive number.');
        }

        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        $reservation_details = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getResultArray();

        $homestay_id = $reservation_details[0]['homestay_id'];
        $unit_type = $reservation_details[0]['unit_type'];
        $unit_numbers = array_unique(array_column($reservation_details, 'unit_number'));
        $day_of_stay = count(array_unique(array_column($reservation_details, 'date')));
        $last_date = date('Y-m-d', strtotime($reservation['check_in'] . ' + ' . ($day_of_stay - 1) . ' days'));

        // Check availability for the new dates
        for ($i = 1; $i <= $extend_days; $i++) {
            $new_date = date('Y-m-d', strtotime($last_date . " +{$i} days"));
            foreach ($unit_numbers as $unit_number) {
                $is_booked = $this->reservationHomestayUnitDetailModel->get_unit_number_not_available($homestay_id, $unit_type, $new_date)->getResultArray();
                if (!empty($is_booked)) {
                    foreach ($is_booked as $booked_unit) {
                        if ($booked_unit['unit_number'] == $unit_number) {
                            return redirect()->back()->with('error', "Unit {$unit_number} is not available on {$new_date}.");
                        }
                    }
                }
            }
        }

        // Add new reservation details
        for ($i = 1; $i <= $extend_days; $i++) {
            $new_date = date('Y-m-d', strtotime($last_date . " +{$i} days"));
            foreach ($unit_numbers as $unit_number) {
                $detailData = [
                    'reservation_id' => $id,
                    'homestay_id' => $homestay_id,
                    'unit_type' => $unit_type,
                    'unit_number' => $unit_number,
                    'date' => $new_date
                ];
                $this->reservationHomestayUnitDetailModel->insert($detailData, false);
            }
        }

        // Recalculate total price and update reservation
        $this->updateReservationTotalPrice($id);

        // Reset payment status to allow for new payment
        $updateData = [
            'status' => '1', // Back to "Pay Deposit" status
            'deposit_proof' => null,
            'deposit_at' => null,
            'deposit_confirmed_at' => null,
            'full_paid_proof' => null,
            'full_paid_at' => null,
            'full_paid_confirmed_at' => null,
        ];
        $this->reservationModel->update($id, $updateData);

        return redirect()->to(base_url('web/reservation/detail/' . $id))->with('success', 'Reservation extended successfully. Please proceed with the new payment.');
    }

    private function updateReservationTotalPrice($reservation_id)
    {
        $reservation = $this->reservationModel->find($reservation_id);
        if (!$reservation) {
            return false;
        }

        // Recalculate homestay unit price
        $reservation_details = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($reservation_id)->getResultArray();
        $day_of_stay = count(array_unique(array_column($reservation_details, 'date')));
        $unit_numbers = array_unique(array_column($reservation_details, 'unit_number'));

        $unit_price = 0;
        foreach ($unit_numbers as $unit_number) {
            $unit = $this->homestayUnitModel->get_hu_by_id_api($reservation_details[0]['homestay_id'], $reservation_details[0]['unit_type'], $unit_number)->getRowArray();
            $unit_price += $unit['price'] ?? 0;
        }

        $total_unit_price = $unit_price * $day_of_stay;

        // Recalculate amenities price
        $amenities_price = $this->reservationHomestayAdditionalAmenitiesDetailModel->get_total_price_by_rid($reservation_id);

        // Recalculate package price
        $package_price = $this->reservationPackageDetailModel->get_total_price_by_rid($reservation_id);

        $new_total_price = $total_unit_price + $amenities_price + $package_price;
        return $this->reservationModel->update($reservation_id, ['total_price' => $new_total_price]);
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
                $this->checkIsReservationCancel($reservation);
            }
            if ($reservation['status'] == 'Payment Successful') {
                $this->checkIsReservationDone($reservation);
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
        if (empty($reservation)) {
            die('Debug Show: Reservation data is not found for id: ' . $id);
        }

        if ($reservation['customer_id'] == null) {
            $coin['total_coin'] = 0;
        } else {
            $coin = $this->userModel->get_user_coin_by_id($reservation['customer_id'])->getRowArray();
            if (empty($coin)) {
                $coin = ['total_coin' => 0];
            }
        }

        if (($reservation['canceled_at'] == null) && ($reservation['status'] != 'Done')) {
            $this->checkIsReservationCancel($reservation);
        }
        if ($reservation['status'] == 'Payment Successful') {
            $this->checkIsReservationDone($reservation);
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
        foreach ($reservation_detail as $detail) {
            $day_of_stay[] = $detail['date'];
            $unit_number[] = $detail['unit_number'];
            $homestay_id[] = $detail['homestay_id'];
            $unit_type[] = $detail['unit_type'];
        }
        $day_of_stay = array_unique($day_of_stay);
        $unit_number = array_values(array_unique($unit_number));
        $homestay_id = array_unique($homestay_id);
        $unit_type = array_unique($unit_type);

        if (empty($homestay_id) || empty($unit_type)) {
            die('Debug Show: Reservation details are incomplete for id: ' . $id);
        }

        $homestay_units = array();
        for ($j = 0; $j < count($unit_number); $j++) {
            $homestay_unit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id[0], $unit_type[0], $unit_number[$j])->getRowArray();
            if ($homestay_unit) {
                $homestay_units[] = $homestay_unit;
            }
        }

        for ($i = 0; $i < count($homestay_units); $i++) {
            if (isset($homestay_units[$i]['unit_type']) && isset($homestay_units[$i]['unit_number'])) {
                $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id[0], $homestay_units[$i]['unit_type'], $homestay_units[$i]['unit_number'])->getResultArray();
                $galleries = array();
                foreach ($list_gallery as $gallery) {
                    $galleries[] = $gallery['url'];
                }
                $homestay_units[$i]['galleries'] = $galleries;
            }
        }

        $check_out = date("Y-m-d 12:00:00", strtotime($reservation['check_in'] . ' + ' . count($day_of_stay) . ' days'));
        $reservation['check_out'] = $check_out;

        $homestay_data = $this->homestayModel->get_hs_by_id_api($homestay_id[0])->getRowArray();
        if (empty($homestay_data)) {
            die('Debug Show: Homestay data not found for homestay_id: ' . $homestay_id[0]);
        }

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
            if ($amenities) {
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

    public function confirmReservation($id = null)
    {
        $request = $this->request->getPost();
        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();
        $user = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();
        $reservation_detail = $this->reservationHomestayUnitDetailModel->get_reservation_by_id($id)->getRowArray();
        $homestay = $this->homestayModel->get_hs_by_id_api($reservation_detail['homestay_id'])->getRowArray();
        $owner = $this->userModel->get_user_by_id($homestay['owner'])->getRowArray();
        $roleUser = $this->userModel->get_role_by_id($user['id'])->getRowArray();
        $user['role'] = $roleUser['name'];
        $roleOwner = $this->userModel->get_role_by_id($owner['id'])->getRowArray();
        $owner['role'] = $roleOwner['name'];

        $confirm = $this->reservationModel->confirm_reservation($request, $id);

        if ($confirm) {
            if ($request['is_rejected'] == '0') {
                $messageUser = 'Your reservation with ID ' . $id . ' at ' . $homestay['name'] . ' has been confirmed by the owner.';
                $messageOwner = 'You have confirmed a reservation with ID ' . $id . ' from @' . $user['username'] . '.';
                session()->setFlashdata('success', 'Reservation confirmed successfully.');
            } else {
                $messageUser = 'Your reservation with ID ' . $id . ' at ' . $homestay['name'] . ' has been rejected by the owner.';
                $messageOwner = 'You have rejected a reservation with ID ' . $id . ' from @' . $user['username'] . '.';
                session()->setFlashdata('error', 'Reservation rejected.');
            }
            $this->notification->sendMessage($user, $messageUser);
            $this->notification->sendMessage($owner, $messageOwner);
            return redirect()->to(base_url('dashboard/Reservation/detail/' . $id));
        } else {
            session()->setFlashdata('error', 'Failed to update reservation status.');
            return redirect()->back()->withInput();
        }
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
            return redirect()->to(base_url('dashboard/Reservation/detail/' . $reservation_id));
        } else {
            return redirect()->back()->withInput();
        }
    }
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
