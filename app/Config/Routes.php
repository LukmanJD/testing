<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/api/dbCheck', 'Home::dbCheck');
$routes->get('/', 'LandingPage::index');
$routes->get('/tes', 'Tes::index');
$routes->get('/add/village', 'LandingPage::addVillage');
$routes->post('/add/village/new', 'web\TouristArea::addTouristArea');
$routes->get('/kab-kota', 'LandingPage::getKabKotaData');
$routes->get('/403', 'Home::error403');
$routes->get('/login', 'Web\Profile\Profile::login');
$routes->get('/register', 'Web\Profile\Profile::register');
$routes->get('/setup', 'LandingPage::setup',  ['filter' => 'role:admin']);
$routes->post('/setup', 'LandingPage::selectVillage',  ['filter' => 'role:admin']);

$routes->post('api/message/send', 'Api\Notification::sendMessage');

$routes->get('/mailWithPHPMailer', 'LandingPage::mailWithPHPMailer');

$routes->get('authgoogle/login', 'AuthGoogle::login');
$routes->get('authgoogle/callback', 'AuthGoogle::callback');
$routes->get('authgoogle/register', 'AuthGoogle::register');

$routes->post('LandingPage/sendMail', 'LandingPage::sendMail');

// Upload files
$routes->group('upload', ['namespace' => 'App\Controllers\Web\Upload'], function ($routes) {
    $routes->post('photo', 'Upload::photo');
    $routes->post('video', 'Upload::video');
    $routes->post('avatar', 'Upload::avatar');
    $routes->delete('avatar', 'Upload::remove');
    $routes->delete('photo', 'Upload::remove');
    $routes->delete('video', 'Upload::remove');
});

// Profile
$routes->group('web', ['namespace' => 'App\Controllers\Web\Profile'], function ($routes) {
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'Profile::profile', ['filter' => 'login']);
        $routes->get('changePassword', 'Profile::changePassword', ['filter' => 'login']);
        $routes->post('changePassword', 'Profile::changePassword', ['filter' => 'login']);
        $routes->get('update', 'Profile::updateProfile', ['filter' => 'login']);
        $routes->post('update', 'Profile::update', ['filter' => 'login']);
        $routes->get('coinHistory', 'Profile::coinHistory', ['filter' => 'login']);
    });
});

// App
$routes->group('web', ['namespace' => 'App\Controllers\Web'], function ($routes) {
    // $routes->get('explore', 'TouristArea::explore');
    $routes->get('attraction/maps', 'Attraction::maps');
    $routes->get('attraction/detail/(:segment)', 'Attraction::detail/$1');
    $routes->get('uniqueAttraction', 'Attraction::uniqueAttraction');
    $routes->presenter('attraction');
    $routes->presenter('homestay', ['namespace' => 'App\Controllers\Web\Homestay']);
    $routes->get('homestayUnit/(:segment)/detail/(:segment)', 'HomestayUnit::detailUnit/$1/$2', ['namespace' => 'App\Controllers\Web\HomestayUnit']);
    $routes->get('homestayUnit/(:segment)', 'HomestayUnit::getListUnit/$1', ['namespace' => 'App\Controllers\Web\HomestayUnit']);
    $routes->get('homestayPackage/detail/(:segment)/(:segment)', 'tourismPackage::show/$1/$2');
    $routes->get('homestayPackage/(:segment)', 'TourismPackage::getListPackage/$1');
    $routes->get('homestayActivity/(:segment)', 'ExclusiveActivity::getListActivity/$1');
    $routes->get('homestayAdditionalAmenities/(:segment)', 'AdditionalAmenities::getListAdditionalAmenities/$1', ['namespace' => 'App\Controllers\Web\AdditionalAmenities']);
    $routes->get('getAdditionalAmenities/(:segment)/(:segment)', 'AdditionalAmenities::getAdditionalAmenities/$1/$2',  ['namespace' => 'App\Controllers\Web\AdditionalAmenities', 'filter' => 'role:user']);
    $routes->delete('additionalAmenities/delete/(:segment)/(:segment)/(:segment)', 'AdditionalAmenities::deleteAdditionalAmenities/$1/$2/$3',  ['namespace' => 'App\Controllers\Web\AdditionalAmenities', 'filter' => 'role:user']);
    $routes->presenter('souvenirPlace', ['namespace' => 'App\Controllers\Web\SouvenirPlace']);
    $routes->presenter('culinaryPlace', ['namespace' => 'App\Controllers\Web\CulinaryPlace']);
    $routes->presenter('worshipPlace', ['namespace' => 'App\Controllers\Web\WorshipPlace']);
    $routes->presenter('serviceProvider');
    $routes->presenter('rumahGadang');
    $routes->get('/', 'TouristArea::index');
    $routes->get('event/maps', 'Event::maps');
    $routes->get('event/detail/(:segment)', 'Event::detail/$1');
    $routes->presenter('event');
    $routes->get('reservation', 'Reservation::listReservation', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/cancel/(:segment)', 'Reservation::cancelReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/refund/confirm/(:segment)', 'Reservation::confirmRefund/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/invoice/(:segment)', 'PdfController::generatePDF/$1', ['namespace' => 'App\Controllers\Web\PdfController', 'filter' => 'role:user']);
    $routes->get('reservation/(:segment)', 'Reservation::newReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/detail/(:segment)', 'Reservation::detailReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->delete('reservation/delete/(:segment)', 'Reservation::delete/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/addAmenities', 'Reservation::addAmenities', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/addActivity', 'Reservation::addActivity', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/review/(:segment)', 'Reservation::addReview/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/(:segment)', 'Reservation::createReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/unit/(:segment)/(:segment)/(:segment)/(:segment)', 'Reservation::getUnit/$1/$2/$3/$4', ['namespace' => 'App\Controllers\Web\Reservation']);
    $routes->get('reservation/finish/(:segment)/(:segment)/(:segment)/(:segment)', 'Reservation::finishReservation/$1/$2/$3/$4', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/price/confirm/(:segment)/(:segment)', 'Reservation::confirmPackagePrice/$1/$2', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/delete/(:segment)', 'Reservation::deletePackage/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/extendPackage/(:segment)/(:segment)/(:segment)', 'Reservation::customPackage/$1/$2/$3', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/customPackage/(:segment)/(:segment)/(:segment)', 'Reservation::customPackage/$1/$2/$3', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/(:segment)/(:segment)', 'Reservation::getPackage/$1/$2', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/extend/(:segment)/(:segment)/(:segment)', 'Reservation::createExtendPackage/$1/$2/$3', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('reservation/package/custom/(:segment)/(:segment)', 'Reservation::createCustomPackage/$1/$2', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/package/buy/(:segment)/(:segment)/(:segment)', 'Reservation::buyPackage/$1/$2/$3', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/payDeposit/(:segment)', 'Reservation::payDeposit/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/payFull/(:segment)', 'Reservation::payFull/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/bankAccount/create', 'Reservation::createBankAccount', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservation/bankAccount/update/(:segment)', 'Reservation::updateBankAccount/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('visitHistory', 'VisitHistory::visitHistory', ['filter' => 'role:user']);
    $routes->get('visitHistory/add', 'VisitHistory::addVisitHistory', ['filter' => 'role:user']);
    $routes->post('visitHistory', 'VisitHistory::visitHistory', ['filter' => 'role:user']);
    $routes->post('review', 'Review::add', [['filter' => 'role:user']]);

    $routes->presenter('packageDay',  ['filter' => 'role:user']);
    $routes->delete('packageDay/delete/(:segment)/(:segment)/(:segment)', 'PackageDay::delete/$1/$2/$3',  ['filter' => 'role:user']);

    $routes->get('packageDetail/getObject/(:segment)/(:segment)/(:segment)/(:segment)', 'PackageDetail::getObject/$1/$2/$3/$4',  ['filter' => 'role:user']);
    $routes->presenter('packageDetail',  ['filter' => 'role:user']);
    $routes->delete('packageDetail/delete/(:segment)/(:segment)/(:segment)/(:segment)', 'PackageDetail::delete/$1/$2/$3/$4',  ['filter' => 'role:user']);

    $routes->get('packageService/(:segment)/(:segment)', 'PackageService::getService/$1/$2',  ['filter' => 'role:user']);
    $routes->presenter('packageService',  ['filter' => 'role:user']);
    $routes->delete('packageService/delete/(:segment)/(:segment)/(:segment)', 'PackageService::delete/$1/$2/$3',  ['filter' => 'role:user']);
    $routes->get('payment', 'PaymentController::createTransaction');
    $routes->get('payment/(:segment)', 'PaymentController::checkPaymentStatus/$1');
    $routes->post('saveToken', 'ReservationController::saveToken');
    $routes->post('reservationRefund', 'Reservation::addAccountRefund', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->get('allObject', 'TouristArea::allObject');
    $routes->get('reservationEvent/(:segment)', 'Reservation::newReservationEvent/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);
    $routes->post('reservationEvent/(:segment)', 'Reservation::createReservationEvent/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:user']);

    $routes->get('aroundYou', 'TouristArea::aroundYou', ['namespace' => 'App\Controllers\Web']);

    $routes->get('homestay_detail_mobile/(:segment)', 'Homestay::detailMobile/$1', ['namespace' => 'App\Controllers\Web\Homestay']);
    $routes->get('homestay_unit_detail_mobile/(:segment)/(:segment)/(:segment)', 'HomestayUnit::unitDetailMobile/$1/$2/$3', ['namespace' => 'App\Controllers\Web\HomestayUnit']);
    $routes->get('additional_amenitie_detail_mobile/(:segment)/(:segment)', 'AdditionalAmenities::detailAdditionalAmenitiesMobile/$1/$2', ['namespace' => 'App\Controllers\Web\AdditionalAmenities']);
    $routes->get('list_homestay_mobile', 'Homestay::maps', ['namespace' => 'App\Controllers\Web\Homestay']);
});

// Dashboard
$routes->group('dashboard', ['namespace' => 'App\Controllers\Web', 'filter' => 'role:admin,owner'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('rumahGadang', 'Dashboard::rumahGadang',  ['filter' => 'role:owner']);
    $routes->get('event', 'Dashboard::event',  ['filter' => 'role:admin']);
    $routes->get('facility', 'Dashboard::facility', ['filter' => 'role:admin']);
    $routes->get('recommendation', 'Dashboard::recommendation',  ['filter' => 'role:admin']);
    $routes->get('users', 'Dashboard::users', ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);

    $routes->get('homestay', 'Dashboard::homestay',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:owner']);
    $routes->get('homestay/manage', 'Dashboard::homestay',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->get('worshipPlace', 'Dashboard::worshipPlace',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->get('serviceProvider', 'Dashboard::serviceProvider',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->get('souvenirPlace', 'Dashboard::souvenirPlace',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->get('culinaryPlace', 'Dashboard::culinaryPlace',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->get('attraction', 'Dashboard::attraction',  ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);

    $routes->get('homestay/manage/new', 'Homestay::new',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('homestay/manage', 'Homestay::create',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->get('homestay/manage/(:segment)', 'Homestay::show/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->get('homestay/manage/edit/(:segment)', 'Homestay::edit/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('homestay/manage/update/(:segment)', 'Homestay::update/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);

    $routes->get('facilityHomestay', 'Homestay::facilityHomestay',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('facilityHomestay', 'Homestay::addNewFacilityHomestay',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('facilityHomestay/edit/(:segment)', 'Homestay::editFacilityHomestay/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->delete('facilityHomestay/delete/(:segment)', 'Homestay::deleteFacilityHomestay/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);

    $routes->get('facilitySouvenirPlace', 'SouvenirPlace::facilitySouvenirPlace',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('facilitySouvenirPlace', 'SouvenirPlace::addNewFacilitySouvenirPlace',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('facilitySouvenirPlace/edit/(:segment)', 'SouvenirPlace::editFacilitySouvenirPlace/$1',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->delete('facilitySouvenirPlace/delete/(:segment)', 'SouvenirPlace::deleteFacilitySouvenirPlace/$1',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);

    $routes->get('facilityCulinaryPlace', 'CulinaryPlace::facilityCulinaryPlace',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('facilityCulinaryPlace', 'CulinaryPlace::addNewFacilityCulinaryPlace',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('facilityCulinaryPlace/edit/(:segment)', 'CulinaryPlace::editFacilityCulinaryPlace/$1',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->delete('facilityCulinaryPlace/delete/(:segment)', 'CulinaryPlace::deleteFacilityCulinaryPlace/$1',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);

    $routes->get('facilityWorshipPlace', 'WorshipPlace::facilityWorshipPlace',  ['namespace' => 'App\Controllers\Web\WorshipPlace', 'filter' => 'role:admin']);
    $routes->post('facilityWorshipPlace', 'WorshipPlace::addNewFacilityWorshipPlace',  ['namespace' => 'App\Controllers\Web\WorshipPlace', 'filter' => 'role:admin']);
    $routes->post('facilityWorshipPlace/edit/(:segment)', 'WorshipPlace::editFacilityWorshipPlace/$1',  ['namespace' => 'App\Controllers\Web\WorshipPlace', 'filter' => 'role:admin']);
    $routes->delete('facilityWorshipPlace/delete/(:segment)', 'WorshipPlace::deleteFacilityWorshipPlace/$1',  ['namespace' => 'App\Controllers\Web\WorshipPlace', 'filter' => 'role:admin']);

    $routes->get('facilityUnit', 'Homestay::facilityUnit',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('facilityUnit', 'Homestay::addNewFacilityHomestayUnit',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->post('facilityUnit/edit/(:segment)', 'Homestay::editFacilityUnit/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);
    $routes->delete('facilityUnit/delete/(:segment)', 'Homestay::deleteFacilityUnit/$1',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:admin']);

    $routes->post('homestayUnit/facility/(:segment)/(:segment)/(:segment)', 'HomestayUnit::addNewFacility/$1/$2/$3',  ['namespace' => 'App\Controllers\Web\HomestayUnit', 'filter' => 'role:owner']);
    $routes->post('homestayUnit/facility/edit/(:segment)/(:segment)/(:segment)/(:segment)', 'HomestayUnit::editFacility/$1/$2/$3/$4',  ['namespace' => 'App\Controllers\Web\HomestayUnit', 'filter' => 'role:owner']);
    $routes->delete('homestayUnit/facility/delete/(:segment)/(:segment)/(:segment)/(:segment)', 'HomestayUnit::deleteFacility/$1/$2/$3/$4',  ['namespace' => 'App\Controllers\Web\HomestayUnit', 'filter' => 'role:owner']);

    $routes->presenter('homestayUnit',  ['namespace' => 'App\Controllers\Web\HomestayUnit', 'filter' => 'role:owner']);
    $routes->delete('homestayUnit/delete/(:segment)', 'HomestayUnit::delete/$1',  ['namespace' => 'App\Controllers\Web\HomestayUnit', 'filter' => 'role:owner']);

    $routes->presenter('exclusiveActivity',  ['filter' => 'role:owner']);
    $routes->delete('exclusiveActivity/delete/(:segment)/(:segment)', 'ExclusiveActivity::delete/$1/$2',  ['filter' => 'role:owner']);

    $routes->presenter('additionalAmenities',  ['namespace' => 'App\Controllers\Web\AdditionalAmenities', 'filter' => 'role:owner']);
    $routes->delete('additionalAmenities/delete/(:segment)/(:segment)', 'AdditionalAmenities::delete/$1/$2',  ['namespace' => 'App\Controllers\Web\AdditionalAmenities', 'filter' => 'role:owner']);

    $routes->presenter('tourismPackage',  ['filter' => 'role:owner']);
    $routes->delete('tourismPackage/delete/(:segment)/(:segment)', 'TourismPackage::delete/$1/$2',  ['filter' => 'role:owner']);

    $routes->presenter('packageDay',  ['filter' => 'role:owner']);
    $routes->delete('packageDay/delete/(:segment)/(:segment)/(:segment)', 'PackageDay::delete/$1/$2/$3',  ['filter' => 'role:owner']);

    $routes->get('packageDetail/getObject/(:segment)/(:segment)/(:segment)', 'PackageDetail::getObject/$1/$2/$3',  ['filter' => 'role:owner']);
    $routes->presenter('packageDetail',  ['filter' => 'role:owner']);
    $routes->delete('packageDetail/delete/(:segment)/(:segment)/(:segment)/(:segment)', 'PackageDetail::delete/$1/$2/$3/$4',  ['filter' => 'role:owner']);

    $routes->get('packageService/(:segment)/(:segment)', 'PackageService::getService/$1/$2',  ['filter' => 'role:owner']);
    $routes->presenter('packageService',  ['filter' => 'role:owner']);
    $routes->delete('packageService/delete/(:segment)/(:segment)/(:segment)', 'PackageService::delete/$1/$2/$3',  ['filter' => 'role:owner']);

    $routes->post('event/date', 'Event::addDate',  ['filter' => 'role:admin']);
    $routes->delete('event/(:segment)/date/(:segment)', 'Event::deleteDate/$1/$2',  ['filter' => 'role:admin']);
    $routes->presenter('event',  ['filter' => 'role:admin']);

    $routes->post('reservation/refund/(:segment)', 'Reservation::refundReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->post('reservation/package/price/(:segment)/(:segment)', 'Reservation::setPackagePrice/$1/$2', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->post('reservation/fullPay/confirm/(:segment)', 'Reservation::confirmFullPayReservation/$1',  ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->post('reservation/deposit/confirm/(:segment)', 'Reservation::confirmDepositReservation/$1',  ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->post('reservation/confirm/(:segment)', 'Reservation::confirmReservation/$1',  ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->delete('reservation/delete/(:segment)', 'Reservation::delete/$1',  ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->get('reservation/detail/(:segment)', 'reservation::show/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);
    $routes->presenter('reservation',  ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);

    $routes->presenter('rumahGadang',  ['filter' => 'role:owner']);
    $routes->presenter('homestay',  ['namespace' => 'App\Controllers\Web\Homestay', 'filter' => 'role:owner']);
    $routes->presenter('worshipPlace',  ['namespace' => 'App\Controllers\Web\WorshipPlace', 'filter' => 'role:admin']);

    $routes->presenter('serviceProvider',  ['filter' => 'role:admin']);
    $routes->post('serviceProvider/service', 'ServiceProvider::addService',  ['filter' => 'role:admin']);
    $routes->post('serviceProvider/service/edit/(:segment)', 'ServiceProvider::editService/$1');
    $routes->delete('serviceProvider/service/delete/(:segment)', 'ServiceProvider::deleteService/$1');

    $routes->get('souvenirPlace/product', 'souvenirPlace::listProduct',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->presenter('souvenirPlace',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('souvenirPlace/product', 'souvenirPlace::addNewProduct',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('souvenirPlace/(:segment)/product', 'souvenirPlace::addProduct',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('souvenirPlace/product/edit/(:segment)', 'souvenirPlace::editProduct/$1', ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->post('souvenirPlace/(:segment)/product/(:segment)', 'souvenirPlace::editSouvenirProduct/$1/$2',  ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->delete('souvenirPlace/product/delete/(:segment)', 'souvenirPlace::deleteProduct/$1', ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);
    $routes->delete('souvenirPlace/(:segment)/product/(:segment)/delete', 'souvenirPlace::deleteSouvenirProduct/$1/$2', ['namespace' => 'App\Controllers\Web\SouvenirPlace', 'filter' => 'role:admin']);

    $routes->get('culinaryPlace/product', 'culinaryPlace::listProduct',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->presenter('culinaryPlace',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('culinaryPlace/product', 'culinaryPlace::addNewProduct',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('culinaryPlace/(:segment)/product', 'culinaryPlace::addProduct',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('culinaryPlace/product/edit/(:segment)', 'culinaryPlace::editProduct/$1', ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->post('culinaryPlace/(:segment)/product/(:segment)', 'culinaryPlace::editCulinaryProduct/$1/$2',  ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->delete('culinaryPlace/product/delete/(:segment)', 'culinaryPlace::deleteProduct/$1', ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);
    $routes->delete('culinaryPlace/(:segment)/product/(:segment)/delete', 'culinaryPlace::deleteCulinaryProduct/$1/$2', ['namespace' => 'App\Controllers\Web\CulinaryPlace', 'filter' => 'role:admin']);

    $routes->get('attraction/facility', 'attraction::listFacility',  ['filter' => 'role:admin']);
    $routes->presenter('attraction',  ['filter' => 'role:admin']);
    $routes->post('attraction/ticket', 'attraction::addNewTicket',  ['filter' => 'role:admin']);
    $routes->post('attraction/ticket/edit/(:segment)', 'attraction::editTicket/$1',  ['filter' => 'role:admin']);
    $routes->delete('attraction/ticket/delete/(:segment)', 'attraction::deleteTicket/$1',  ['filter' => 'role:admin']);
    $routes->post('attraction/facility', 'attraction::addNewFacility',  ['filter' => 'role:admin']);
    $routes->post('attraction/facility/edit/(:segment)', 'attraction::editFacility/$1');
    $routes->delete('attraction/facility/delete/(:segment)', 'attraction::deletefacility/$1');

    $routes->presenter('facility', ['filter' => 'role:admin']);
    $routes->presenter('users', ['namespace' => 'App\Controllers\Web\Users', 'filter' => 'role:admin']);
    $routes->post('reservation/(:segment)', 'Reservation::manualReservation/$1', ['namespace' => 'App\Controllers\Web\Reservation', 'filter' => 'role:owner']);

    $routes->presenter('villages',  ['namespace' => 'App\Controllers\Web\Villages', 'filter' => 'role:admin']);
    $routes->presenter('homestayCertification',  ['namespace' => 'App\Controllers\Web', 'filter' => 'role:owner']);

    $routes->get('announcement', 'Dashboard::announcement', ['namespace' => 'App\Controllers\Web\Dashboard', 'filter' => 'role:admin']);
    $routes->post('announcement/add', 'Villages::createannouncement', ['namespace' => 'App\Controllers\Web\Villages', 'filter' => 'role:admin']);
    $routes->post('announcement/update/(:segment)', 'Villages::updateannouncement/$1', ['namespace' => 'App\Controllers\Web\Villages', 'filter' => 'role:admin']);
    // $routes->post('announcement/delete/(:segment)', 'Villages::deleteobject/$1', ['namespace' => 'App\Controllers\Web\Villages', 'filter' => 'role:admin']);
    $routes->delete('announcement/delete/(:segment)', 'Villages::deleteobject/$1', ['namespace' => 'App\Controllers\Web\Villages', 'filter' => 'role:admin']);
});

// API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->resource('homestay');
    $routes->post('homestay/findByRadius', 'Homestay::findByRadius');
    $routes->post('homestay/findByName', 'Homestay::findByName');
    $routes->post('homestay/findByRating', 'Homestay::findByRating');
    $routes->get('homestayFacility', 'Homestay::getFacility');
    $routes->post('homestay/findByFacility', 'Homestay::findByFacility');
    $routes->post('homestay/findByUnit', 'Homestay::findByUnit');
    $routes->post('homestay/findByCategory', 'Homestay::findByCategory');
    $routes->get('uAttraction', 'Attraction::uIndex');
    $routes->resource('attraction');
    $routes->post('attraction/get/(:segment)', 'Attraction::show');
    $routes->post('attraction/findByRadius', 'Attraction::findByRadius');
    $routes->post('attraction/findByName', 'Attraction::findByName');
    $routes->get('attractionFacility', 'Attraction::getFacility');
    $routes->post('attraction/findByFacility', 'Attraction::findByFacility');
    $routes->resource('rumahGadang');
    $routes->get('recommendation', 'RumahGadang::recommendation');
    $routes->post('recommendationOwner', 'RumahGadang::recommendationByOwner');
    $routes->get('recommendationList', 'RumahGadang::recommendationList');
    $routes->post('recommendation', 'RumahGadang::updateRecommendation');
    $routes->post('rumahGadangOwner', 'RumahGadang::listByOwner');
    $routes->post('rumahGadang/findByName', 'RumahGadang::findByName');
    $routes->post('rumahGadang/findByRadius', 'RumahGadang::findByRadius');
    $routes->post('rumahGadang/findByFacility', 'RumahGadang::findByFacility');
    $routes->post('rumahGadang/findByRating', 'RumahGadang::findByRating');
    $routes->post('rumahGadang/findByCategory', 'RumahGadang::findByCategory');
    $routes->get('rumahGadang/maps', 'RumahGadang::maps');
    $routes->get('event/category', 'Event::category');
    $routes->resource('event');
    $routes->post('eventOwner', 'Event::listByOwner');
    $routes->post('event/findByName', 'Event::findByName');
    $routes->post('event/findByRadius', 'Event::findByRadius');
    $routes->post('event/findByRating', 'Event::findByRating');
    $routes->post('event/findByCategory', 'Event::findByCategory');
    $routes->post('event/findByDate', 'Event::findByDate');
    $routes->resource('culinaryPlace');
    $routes->post('culinaryPlaceOwner', 'CulinaryPlace::listByOwner');
    $routes->post('culinaryPlace/findByRadius', 'CulinaryPlace::findByRadius');
    $routes->resource('worshipPlace');
    $routes->post('worshipPlaceOwner', 'WorshipPlace::listByOwner');
    $routes->post('worshipPlace/findByRadius', 'WorshipPlace::findByRadius');
    $routes->resource('souvenirPlace');
    $routes->post('souvenirPlaceOwner', 'SouvenirPlace::listByOwner');
    $routes->post('souvenirPlace/findByRadius', 'SouvenirPlace::findByRadius');
    $routes->resource('serviceProvider');
    $routes->post('serviceProvider/findByRadius', 'ServiceProvider::findByRadius');
    $routes->resource('account');
    $routes->post('account/profile', 'Account::profile');
    $routes->post('account/changePassword', 'Account::changePassword');
    $routes->post('account/visitHistory', 'Account::visitHistory');
    $routes->post('account/newVisitHistory', 'Account::newVisitHistory');
    $routes->post('account/(:num)', 'Account::update/$1');
    $routes->resource('review');
    $routes->resource('user');
    $routes->get('owner', 'User::owner');
    $routes->resource('facility');
    $routes->post('village', 'Village::getData');
    $routes->get('touristVillage', 'Village::gettouristVillageData');
    $routes->get('uniqueAttraction', 'Village::getUniqueAttData');
    $routes->get('villages', 'Village::getVillagesData');
    $routes->get('village/(:segment)', 'Village::getVillageGeom/$1');
    $routes->get('subdistricts', 'Village::getSubdistrictsData');
    $routes->get('cities', 'Village::getCitiesData');
    $routes->get('provinces', 'Village::getProvincesData');
    $routes->get('countries', 'Village::getCountriesData');
    $routes->post('login', 'Profile::attemptLogin');
    $routes->post('profile', 'Profile::profile');
    $routes->get('logout', 'Profile::logout');

    $routes->get('aTTCat', 'Attraction::getATTCat');
    $routes->get('wPCat', 'WorshipPlace::getWPCat');
    $routes->get('selectVillage', 'Village::selectVillage');
    $routes->get('proList/(:segment)', 'souvenirPlace::proList/$1');
    $routes->get('culList/(:segment)', 'culinaryPlace::culList/$1');
    $routes->get('homestayUnitFac/(:segment)/(:segment)/(:segment)', 'Homestay::homestayUnitFac/$1/$2/$3');
    $routes->get('getHomestayNameByUser/(:segment)', 'Homestay::getNameByUser/$1');
    $routes->get('socials', 'Village::getSocials');

    $routes->post('attraction/findAll', 'Attraction::findAll');
    $routes->post('homestay/findAll', 'Homestay::findAll');
    $routes->post('culinaryPlace/findAll', 'CulinaryPlace::findAll');
    $routes->post('souvenirPlace/findAll', 'SouvenirPlace::findAll');
    $routes->post('worshipPlace/findAll', 'WorshipPlace::findAll');

    $routes->get('attraction_mobile', 'Attraction::attractionMobile');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
