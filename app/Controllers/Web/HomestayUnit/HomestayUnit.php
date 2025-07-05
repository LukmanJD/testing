<?php

namespace App\Controllers\Web\HomestayUnit;

// use App\Models\DetailFacilityRumahGadangModel;
// use App\Models\FacilityRumahGadangModel;
// use App\Models\GalleryRumahGadangModel;
// use App\Models\ReviewModel;
// use App\Models\RumahGadangModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\Homestay\HomestayModel;
use App\Models\Homestay\HomestayUnitModel;
use App\Models\Homestay\HomestayUnitFacilityDetailModel;
use App\Models\Homestay\HomestayUnitGalleryModel;
use App\Models\Homestay\HomestayUnitTypeModel;
use App\Models\Homestay\HomestayFacilityModel;
use App\Models\Homestay\HomestayFacilityDetailModel;
use App\Models\Homestay\HomestayGalleryModel;

use App\Models\Reservation\ReservationModel;
use App\Models\Reservation\ReservationHomestayUnitDetailModel;

class HomestayUnit extends ResourcePresenter
{
    use ResponseTrait;

    // protected $rumahGadangModel;
    // protected $galleryRumahGadangModel;
    // protected $detailFacilityRumahGadangModel;
    // protected $reviewModel;
    // protected $facilityRumahGadangModel;

    protected $homestayModel;
    protected $homestayUnitModel;
    protected $homestayUnitFacilityDetailModel;
    protected $homestayUnitGalleryModel;
    protected $homestayUnitTypeModel;
    protected $homestayFacilityModel;
    protected $homestayFacilityDetailModel;
    protected $homestayGalleryModel;

    protected $reservationModel;
    protected $reservationHomestayUnitDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        // $this->rumahGadangModel = new RumahGadangModel();
        // $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        // $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        // $this->reviewModel = new ReviewModel();
        // $this->facilityRumahGadangModel = new FacilityRumahGadangModel();

        $this->homestayModel = new HomestayModel();
        $this->homestayUnitModel = new HomestayUnitModel();
        $this->homestayUnitFacilityDetailModel = new HomestayUnitFacilityDetailModel();
        $this->homestayUnitGalleryModel = new HomestayUnitGalleryModel();
        $this->homestayUnitTypeModel = new HomestayUnitTypeModel();
        $this->homestayFacilityModel = new HomestayFacilityModel();
        $this->homestayFacilityDetailModel = new HomestayFacilityDetailModel();
        $this->homestayGalleryModel = new HomestayGalleryModel();

        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayUnitDetailModel = new ReservationHomestayUnitDetailModel();
    }

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $contents = $this->homestayUnitModel->get_list_hu_api($homestay['id'])->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['id'] = $contents[$i]['unit_type'] . $contents[$i]['unit_number'];
        }

        $data = [
            'title' => 'Manage Homestay Unit',
            'category' => 'Homestay Unit',
            'data' => $contents,
        ];

        return view('dashboard/manage', $data);
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $unit_type = substr($id, 0, 1);
        $unit_number = substr($id, 1);

        $homestayUnit = $this->homestayUnitModel->get_hu_by_id_api($homestay['id'], $unit_type, $unit_number)->getRowArray();

        // $avg_rating = $this->reviewModel->get_rating('rumah_gadang_id', $id)->getRowArray()['avg_rating'];

        $list_facility = $this->homestayUnitFacilityDetailModel->get_facility_by_hu_api($homestay['id'], $unit_type, $unit_number)->getResultArray();
        // $facilities = array();
        // foreach ($list_facility as $facility) {
        //     $facilities[] = $facility['name'];
        // }

        // $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();

        $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay['id'], $unit_type, $unit_number)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        // $rumahGadang['avg_rating'] = $avg_rating;
        // $homestay['facilities'] = $facilities;
        // $rumahGadang['reviews'] = $list_review;
        $homestayUnit['gallery'] = $galleries;

        $data = [
            'title' => $homestayUnit['name'],
            'data' => $homestayUnit,
            'facilities' => $list_facility,
        ];

        return view('owner/homestay_unit_detail', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $unit_types = $this->homestayUnitTypeModel->get_list_hu_type_api()->getResultArray();
        $unit_type = array();
        // foreach ($unit_types as $item) {
        //     $unit_type[] = $item['name'];
        // }
        // dd($unit_types);
        $data = [
            'title' => 'New Homestay Unit',
            'unit_type' => $unit_types,
        ];
        return view('owner/homestay_unit_form', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        $request = $this->request->getPost();
        // $id = $this->homestayModel->get_new_id_api();
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        // dd($homestay['id']);
        $id = $this->homestayUnitModel->get_new_id_api($homestay['id'], $request['unit_type']);
        $requestData = [
            'homestay_id' => $homestay['id'],
            'unit_type' => $request['unit_type'],
            'unit_number' => $id,
            'name' => $request['name'],
            'price' => $request['price'],
            'capacity' => $request['capacity'],
            'description' => $request['description'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        // $addHS = $this->homestayModel->add_hs_api($requestData, $geojson);
        $addHS = $this->homestayUnitModel->add_hs_api($requestData);

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
            $this->homestayUnitGalleryModel->add_gallery_api($homestay['id'], $request['unit_type'], $id, $gallery);
        }

        if ($addHS) {
            return redirect()->to(base_url('dashboard/homestayUnit') . '/' . $request['unit_type'] . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $unit_type = substr($id, 0, 1);
        $unit_number = substr($id, 1);

        $homestayUnit = $this->homestayUnitModel->get_hu_by_id_api($homestay['id'], $unit_type, $unit_number)->getRowArray();

        $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay['id'], $unit_type, $unit_number)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $homestayUnit['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Homestay Unit',
            'data' => $homestayUnit,
        ];
        return view('owner/homestay_unit_form', $data);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {

        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $unit_type = substr($id, 0, 1);
        $unit_number = substr($id, 1);

        $request = $this->request->getPost();
        $requestData = [
            'name' => $request['name'],
            'price' => $request['price'],
            'capacity' => $request['capacity'],
            'description' => $request['description'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $updateHS = $this->homestayUnitModel->update_hs_api($homestay['id'], $unit_type, $unit_number, $requestData);

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
            $this->homestayUnitGalleryModel->update_gallery_api($homestay['id'], $unit_type, $unit_number, $gallery);
        } else {
            $this->homestayUnitGalleryModel->delete_gallery_api($homestay['id'], $unit_type, $unit_number);
        }

        if ($updateHS) {
            return redirect()->to(base_url('dashboard/homestayUnit') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $unit_type = substr($id, 0, 1);
        $unit_number = substr($id, 1);

        $deleteS = $this->homestayUnitModel->delete_hu_api($homestay['id'], $unit_type, $unit_number);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Homestay Unit"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Homestay Unit not found"
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
        $data = [
            'title' => 'Home',
            'data' => $contents,
        ];

        return view('web/recommendation', $data);
    }

    public function maps()
    {
        $contents = $this->rumahGadangModel->get_list_rg_api()->getResultArray();
        $data = [
            'title' => 'Rumah Gadang',
            'data' => $contents,
        ];

        return view('maps/rumah_gadang', $data);
    }

    public function detail($id = null)
    {
        $rumahGadang = $this->rumahGadangModel->get_rg_by_id_api($id)->getRowArray();
        if (empty($rumahGadang)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        $avg_rating = $this->reviewModel->get_rating('rumah_gadang_id', $id)->getRowArray()['avg_rating'];

        $list_facility = $this->detailFacilityRumahGadangModel->get_facility_by_rg_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['facility'];
        }

        $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();

        $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }


        $rumahGadang['avg_rating'] = $avg_rating;
        $rumahGadang['facilities'] = $facilities;
        $rumahGadang['reviews'] = $list_review;
        $rumahGadang['gallery'] = $galleries;

        $data = [
            'title' => $rumahGadang['name'],
            'data' => $rumahGadang,
        ];

        if (url_is('*dashboard*')) {
            return view('dashboard/detail_rumah_gadang', $data);
        }
        return view('maps/detail_rumah_gadang', $data);
    }
    public function addNewFacility($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'facility_id' => $request['facility_id'],
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->homestayUnitFacilityDetailModel->add_huf_api($requestData, $homestay_id, $unit_type, $unit_number);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/homestayUnit/' . $unit_type . $unit_number));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editFacility($homestay_id = null, $unit_type = null, $unit_number = null, $facility_id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'description' => $request['description'],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->homestayUnitFacilityDetailModel->update_huf_api($requestData, $homestay_id, $unit_type, $unit_number, $facility_id);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/homestayUnit/' . $unit_type . $unit_number));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteFacility($homestay_id = null, $unit_type = null, $unit_number = null, $facility_id = null)
    {
        $deleteS = $this->homestayUnitFacilityDetailModel->delete_huf_by_id($homestay_id, $unit_type, $unit_number, $facility_id);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Unit Facility"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Unit Facility not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    public function getListUnit($homestay_id = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
        $contents = $this->homestayUnitModel->get_list_hu_api($homestay_id)->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['id'] = $contents[$i]['unit_type'] . $contents[$i]['unit_number'];
        }

        for ($i = 0; $i < count($contents); $i++) {
            $getRID = $this->reservationHomestayUnitDetailModel->get_reservation_by_huid($homestay_id, $contents[$i]['unit_type'], $contents[$i]['unit_number'])->getResultArray();
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
            $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $contents[$i]['unit_type'], $contents[$i]['unit_number'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$i]['galleries'] = $galleries;
        }


        $data = [
            'title' => $homestay['name'],
            'category' => 'Homestay Unit',
            'data' => $contents,
        ];

        $data['homestay_id'] = $homestay_id;
        return view('web/homestay_unit_list', $data);
    }

    public function detailUnit($homestay_id = null, $id = null)
    {
        $unit_type = substr($id, 0, 1);
        $unit_number = substr($id, 1);

        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();

        $homestayUnit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id, $unit_type, $unit_number)->getRowArray();

        $getRID = $this->reservationHomestayUnitDetailModel->get_reservation_by_huid($homestay_id, $unit_type, $unit_number)->getResultArray();

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
        } else {
            $avg_rating = 0;
        }
        $homestayUnit['avg_rating'] = $avg_rating;
        $homestayUnit['rating_review'] = $rating_review;


        $list_facility = $this->homestayUnitFacilityDetailModel->get_facility_by_hu_api($homestay_id, $unit_type, $unit_number)->getResultArray();

        // $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();

        $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $unit_type, $unit_number)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        // $homestay['facilities'] = $facilities;
        // $rumahGadang['reviews'] = $list_review;
        $homestayUnit['gallery'] = $galleries;

        $data = [
            'title' => $homestay['name'],
            'data' => $homestayUnit,
            'facilities' => $list_facility,
        ];

        $data['homestay_id'] = $homestay_id;

        return view('web/homestay_unit_detail', $data);
    }

    public function unitDetailMobile($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();

        $homestayUnit = $this->homestayUnitModel->get_hu_by_id_api($homestay_id, $unit_type, $unit_number)->getRowArray();

        $getRID = $this->reservationHomestayUnitDetailModel->get_reservation_by_huid($homestay_id, $unit_type, $unit_number)->getResultArray();

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
        } else {
            $avg_rating = 0;
        }
        $homestayUnit['avg_rating'] = $avg_rating;
        $homestayUnit['rating_review'] = $rating_review;

        $list_facility = $this->homestayUnitFacilityDetailModel->get_facility_by_hu_api($homestay_id, $unit_type, $unit_number)->getResultArray();

        $list_gallery = $this->homestayUnitGalleryModel->get_gallery_api($homestay_id, $unit_type, $unit_number)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $homestayUnit['gallery'] = $galleries;

        $data = [
            'title' => $homestay['name'],
            'data' => $homestayUnit,
            'facilities' => $list_facility,
        ];

        $data['homestay_id'] = $homestay_id;
        return view('maps/homestay_unit_detail', $data);
    }
}
