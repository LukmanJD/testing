<?php

namespace App\Controllers\Web\PdfController;

use CodeIgniter\Controller;
// use TCPDF;
use App\Libraries\MY_TCPDF as TCPDF;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\Files\File;
use DateTime;

use App\Models\Reservation\ReservationHomestayUnitDetailBackUpModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;
use App\Models\Reservation\ReservationModel;
use App\Models\Reservation\ReservationHomestayAdditionalAmenitiesDetailModel;
use App\Models\Reservation\ReservationHomestayActivityDetailModel;
use App\Models\Homestay\HomestayUnitModel;
use App\Models\Homestay\HomestayAdditionalAmenitiesModel;
use App\Models\Homestay\HomestayExclusiveActivityModel;
use App\Models\PackageModel;
use App\Models\PackageDayModel;
use App\Models\PackageDetailModel;
use App\Models\PackageServiceModel;
use App\Models\PackageServiceDetailModel;

use App\Models\Culinary\CulinaryPlaceModel;
use App\Models\Worship\WorshipPlaceModel;
use App\Models\Souvenir\SouvenirPlaceModel;
use App\Models\ServiceProviderModel;
use App\Models\AttractionModel;
use App\Models\EventModel;
use App\Models\Homestay\HomestayModel;
// use App\Models\AccountModel;
use Myth\Auth\Models\UserModel;
use App\Models\UserBankAccountModel;

use App\Models\VillageModel;

class PdfController extends ResourcePresenter
{
    // protected $gtpModel;

    protected $reservationHomestayUnitDetailBackUpModel;
    protected $reservationHomestayUnitDetailModel;
    protected $reservationModel;
    protected $reservationHomestayAdditionalAmenitiesDetailModel;
    protected $reservationHomestayActivityDetailModel;
    protected $homestayUnitModel;
    protected $homestayAdditionalAmenitiesModel;
    protected $homestayExclusiveActivityModel;
    protected $packageModel;
    protected $packageDayModel;
    protected $packageDetailModel;
    protected $packageServiceModel;
    protected $packageServiceDetailModel;
    protected $culinaryPlaceModel;
    protected $worshipPlaceModel;
    // protected $facilityModel;
    protected $souvenirPlaceModel;
    protected $serviceProviderModel;
    protected $attractionModel;
    protected $eventModel;
    protected $homestayModel;
    // protected $accountModel;
    protected $userModel;
    protected $userBankAccountModel;
    protected $villageModel;
    /**
     * Instance of the main Request object.
     *
     * @var HTTP\IncomingRequest
     */
    protected $request;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        // $this->gtpModel = new GtpModel();
        // $this->galleryGtpModel = new GalleryGtpModel();

        $this->reservationHomestayUnitDetailBackUpModel = new ReservationHomestayUnitDetailBackUpModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayAdditionalAmenitiesDetailModel = new ReservationHomestayAdditionalAmenitiesDetailModel();
        $this->reservationHomestayActivityDetailModel = new ReservationHomestayActivityDetailModel();
        $this->homestayUnitModel = new HomestayUnitModel();
        $this->homestayAdditionalAmenitiesModel = new HomestayAdditionalAmenitiesModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();
        $this->packageModel = new PackageModel();
        $this->packageDayModel = new PackageDayModel();
        $this->packageDetailModel = new PackageDetailModel();
        $this->packageServiceModel = new PackageServiceModel();
        $this->packageServiceDetailModel = new PackageServiceDetailModel();
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->worshipPlaceModel = new WorshipPlaceModel();
        // $this->facilityModel = new FacilityModel();
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->attractionModel = new AttractionModel();
        $this->eventModel = new EventModel();
        $this->homestayModel = new HomestayModel();
        // $this->accountModel = new AccountModel();
        $this->userModel = new UserModel();
        $this->userBankAccountModel = new UserBankAccountModel();
        $this->villageModel = new VillageModel();
    }

    public function generatePDF($id = null)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $village = $this->villageModel->check_village()->getRowArray();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($village['name']);
        $pdf->SetTitle('PDF Invoice ' . $village['name']);
        $pdf->SetSubject($village['name']);
        $pdf->SetKeywords('TCPDF, PDF, invoice');


        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);


        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();

        $customer = $this->userModel->get_user_by_id($reservation['customer_id'])->getRowArray();

        if (empty($reservation)) {
            return redirect()->to(base_url('web/reservation'));
        }

        $reservation = $this->reservationModel->get_reservation_by_id($id)->getRowArray();

        if ($reservation['canceled_at'] != null) {
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

        // $homestay_owner_bank_account = $this->userBankAccountModel->get_user_bank_account($homestay_data['owner'])->getRowArray();

        // $customer_bank_account = $this->userBankAccountModel->get_user_bank_account($reservation['customer_id'])->getRowArray();

        $data = [
            'title' => 'Reservation',
            'reservation' => $reservation,
            'homestay' => $homestay,
            'customer' => $customer,
            // 'homestay_owner_bank_account' => $homestay_owner_bank_account,
            // 'customer_bank_account' => $customer_bank_account,
            'village' => $village,
            'homestay_unit' => $homestay_units,
            'reservation_additional_amenities' => $reservation_additional_amenities,
        ];

        if (!empty($reservation['package_id'])) {
            $package = $this->packageModel->get_package_by_id_api($reservation['homestay_id'], $reservation['package_id'])->getRowArray();
            $data['package'] = $package;
            $data2 = $this->getPackageDetail($reservation['id'], $reservation['homestay_id'], $reservation['package_id']);

            $data = array_merge($data, $data2);
        }

        // dd($data);

        // return view('web/invoice', $data);

        //view mengarah ke invoice.php
        $html = view('web/invoice', $data);

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------
        $this->response->setContentType('application/pdf');
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('invoice' . $village['name'] . '.pdf', 'I');
    }

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index() {}

    public function edit($id = null) {}

    public function update($id = null) {}
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
}
