<?php

namespace App\Controllers\Web;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\FacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use CodeIgniter\Files\File;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourcePresenter;

use App\Models\Homestay\HomestayModel;
use App\Models\Homestay\HomestayFacilityModel;
use App\Models\Homestay\HomestayFacilityDetailModel;
use App\Models\Homestay\HomestayGalleryModel;

use App\Models\AttractionModel;
use App\Models\AttractionTicketPriceModel;
use App\Models\AttractionGalleryModel;
use App\Models\AttractionFacilityModel;
use App\Models\AttractionFacilityDetailModel;

class Attraction extends ResourcePresenter
{
    use ResponseTrait;

    protected $rumahGadangModel;
    protected $galleryRumahGadangModel;
    protected $detailFacilityRumahGadangModel;
    protected $reviewModel;
    protected $facilityRumahGadangModel;

    protected $homestayModel;
    protected $homestayFacilityModel;
    protected $homestayFacilityDetailModel;
    protected $homestayGalleryModel;

    protected $attractionModel;
    protected $attractionTicketPriceModel;
    protected $attractionGalleryModel;
    protected $attractionFacilityModel;
    protected $attractionFacilityDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        $this->reviewModel = new ReviewModel();
        $this->facilityRumahGadangModel = new FacilityRumahGadangModel();

        $this->homestayModel = new HomestayModel();
        $this->homestayFacilityModel = new HomestayFacilityModel();
        $this->homestayFacilityDetailModel = new HomestayFacilityDetailModel();
        $this->homestayGalleryModel = new HomestayGalleryModel();

        $this->attractionModel = new AttractionModel();
        $this->attractionTicketPriceModel = new AttractionTicketPriceModel();
        $this->attractionGalleryModel = new AttractionGalleryModel();
        $this->attractionFacilityModel = new AttractionFacilityModel();
        $this->attractionFacilityDetailModel = new AttractionFacilityDetailModel();
    }

    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->attractionModel->get_list_oat_api()->getResultArray();
        $data = [
            'title' => 'Attraction',
            'data' => $contents,
        ];

        return view('web/list_ordinary_attraction', $data);
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
        $attraction = $this->attractionModel->get_at_by_id_api($id)->getRowArray();
        if (empty($attraction)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        $list_facility = $this->attractionFacilityDetailModel->get_facility_by_at_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }

        $list_gallery = $this->attractionGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $attraction['facilities'] = $facilities;
        $attraction['gallery'] = $galleries;

        $data = [
            'title' => $attraction['name'],
            'data' => $attraction,
        ];

        $data['data']['geoJson'] = [
            'type' => 'Feature',
            'geometry' => json_decode($data['data']['geoJson']),
            'properties' => []
        ];

        if (url_is('*dashboard*')) {
            // return view('dashboard/detail_rumah_gadang', $data);
            return view('admin/attraction_detail', $data);
        }
        // return view('web/detail_rumah_gadang', $data);
        // dd($data['data']['geoJson']);
        return view('web/attraction_detail', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $facilities = $this->attractionFacilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'New Attraction',
            'facilities' => $facilities,
        ];
        return view('admin/attraction_form', $data);
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
        $id = $this->attractionModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'attraction_category' => $request['attraction_category'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'price' => $request['price'],
            'employee_name' => $request['employee_name'],
            'phone' => $request['phone'],
            'description' => $request['description'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];
        if (isset($request['video'])) {
            $folder = $request['video'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $vidFile = new File($filepath . '/' . $filenames[0]);
            $vidFile->move(FCPATH . 'media/videos');
            delete_files($filepath);
            rmdir($filepath);
            $requestData['video_url'] = $vidFile->getFilename();
        }
        $addHS = $this->attractionModel->add_at_api($requestData, $geojson);

        $addFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $addFacilities = $this->attractionFacilityDetailModel->add_facility_api($id, $facilities);
        }

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
            $this->attractionGalleryModel->add_gallery_api($id, $gallery);
        }

        if ($addHS && $addFacilities) {
            return redirect()->to(base_url('dashboard/attraction') . '/' . $id);
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
        $facilities = $this->attractionFacilityModel->get_list_fc_api()->getResultArray();
        $attraction = $this->attractionModel->get_at_by_id_api($id)->getRowArray();
        if (empty($attraction)) {
            return redirect()->to('dashboard/attraction');
        }

        $list_facility = $this->attractionFacilityDetailModel->get_facility_by_at_api($id)->getResultArray();
        $selectedFac = array();
        foreach ($list_facility as $facility) {
            $selectedFac[] = $facility['name'];
        }

        $list_gallery = $this->attractionGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $attraction['facilities'] = $selectedFac;
        $attraction['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Attraction',
            'data' => $attraction,
            'facilities' => $facilities,
        ];
        return view('admin/attraction_form', $data);
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
        $request = $this->request->getPost();
        $requestData = [
            'name' => $request['name'],
            'attraction_category' => $request['attraction_category'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'price' => $request['price'],
            'employee_name' => $request['employee_name'],
            'phone' => $request['phone'],
            'description' => $request['description'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];
        if (isset($request['video'])) {
            $folder = $request['video'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $vidFile = new File($filepath . '/' . $filenames[0]);
            $vidFile->move(FCPATH . 'media/videos');
            delete_files($filepath);
            rmdir($filepath);
            $requestData['video_url'] = $vidFile->getFilename();
        } else {
            $requestData['video_url'] = null;
        }
        $updateHS = $this->attractionModel->update_at_api($id, $requestData, $geojson);

        $updateFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $updateFacilities = $this->attractionFacilityDetailModel->update_facility_api($id, $facilities);
        }

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
            $this->attractionGalleryModel->update_gallery_api($id, $gallery);
        } else {
            $this->attractionGalleryModel->delete_gallery_api($id);
        }

        if ($updateHS && $updateFacilities) {
            return redirect()->to(base_url('dashboard/attraction') . '/' . $id);
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
        //
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
        $contents = $this->attractionModel->get_list_at_api_mobile()->getResultArray();
        $data = [
            'title' => 'Attraction',
            'data' => $contents,
        ];

        return view('maps/attraction', $data);
    }

    public function detail($id = null)
    {
        $attraction = $this->attractionModel->get_at_by_id_api($id)->getRowArray();
        if (empty($attraction)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }

        // $list_ticketPrice = $this->attractionTicketPriceModel->get_ticket_by_at_api($id)->getResultArray();
        $list_facility = $this->attractionFacilityDetailModel->get_facility_by_at_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['name'];
        }

        $list_gallery = $this->attractionGalleryModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $attraction['facilities'] = $facilities;
        $attraction['gallery'] = $galleries;

        $data = [
            'title' => $attraction['name'],
            'data' => $attraction,
        ];

        $data['data']['geoJson'] = [
            'type' => 'Feature',
            'geometry' => json_decode($data['data']['geoJson']),
            'properties' => []
        ];
        return view('maps/attraction_detail', $data);
    }
    public function listFacility()
    {
        $contents = $this->attractionFacilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'Manage Attraction Facility',
            'category' => 'Attraction Facility',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    public function addNewFacility()
    {
        $request = $this->request->getPost();

        $requestData = [
            'name' => $request['name'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->attractionFacilityModel->add_fc_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/attraction/facility'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editFacility($id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'id' => $id,
            'name' => $request['name'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $editSV = $this->attractionFacilityModel->edit_fc_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/attraction/facility'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteFacility($id = null)
    {
        $deleteS = $this->attractionFacilityModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Attraction Facility"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Attraction Facility not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    public function addNewTicket()
    {
        $request = $this->request->getPost();

        $requestData = [
            'attraction_id' => $request['attraction_id'],
            'name' => $request['name'],
            'price' => $request['price'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addSV = $this->attractionTicketPriceModel->add_ticket_api($requestData);

        if ($addSV) {
            return redirect()->to(base_url('dashboard/attraction/' . $request['attraction_id']));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function editTicket($id = null)
    {
        $request = $this->request->getPost();

        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'price' => $request['price'],
        ];
        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $editSV = $this->attractionTicketPriceModel->edit_ticket_api($requestData);

        if ($editSV) {
            return redirect()->to(base_url('dashboard/attraction') . '/' . $request['attraction_id']);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function deleteTicket($id = null)
    {
        $deleteS = $this->attractionTicketPriceModel->delete(['id' => $id]);
        if ($deleteS) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Attraction Ticket"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Attraction Ticket not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function uniqueAttraction()
    {
        $contents = $this->attractionModel->get_uat_api()->getResultArray();
        $data = [
            'title' => 'Unique Attraction',
            'data' => $contents,
        ];

        return view('web/list_ordinary_attraction', $data);
    }
}
