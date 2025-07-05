<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\HomestayModel;
use App\Models\HomestayExclusiveActivityModel;

use App\Models\ReservationModel;
use App\Models\ReservationHomestayActivityDetailModel;

class ExclusiveActivity extends ResourcePresenter
{
    use ResponseTrait;

    protected $homestayModel;
    protected $homestayExclusiveActivityModel;

    protected $reservationModel;
    protected $reservationHomestayActivityDetailModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->homestayModel = new HomestayModel();
        $this->homestayExclusiveActivityModel = new HomestayExclusiveActivityModel();

        $this->reservationModel = new ReservationModel();
        $this->reservationHomestayActivityDetailModel = new ReservationHomestayActivityDetailModel();
    }

    public function index()
    {
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();
        $contents = $this->homestayExclusiveActivityModel->get_list_hea_api($homestay['id'])->getResultArray();

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['id'] = $contents[$i]['activity_id'];
        }

        $data = [
            'title' => 'Manage Homestay Exclusive Activity',
            'category' => 'Homestay Exclusive Activity',
            'data' => $contents,
        ];


        return view('dashboard/manage', $data);
    }
    public function create()
    {
        $request = $this->request->getPost();
        dd($request);
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();

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

        if (isset($request['is_daily'])) {
            $request['is_daily'] = '1';
        } else {
            $request['is_daily'] = '0';
        }

        // if ($request['is_daily'] != '1') {
        //     # code...
        // }
        $requestData = [
            'homestay_id' => $homestay['id'],
            'name' => $request['name'],
            'is_daily' => $request['is_daily'],
            'price' => $request['price'],
            'description' => $request['description'],
            'image_url' => $gallery[0],
        ];


        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $addHS = $this->homestayExclusiveActivityModel->add_hea_api($requestData);


        if ($addHS) {
            return redirect()->to(base_url('dashboard/exclusiveActivity'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function update($activity_id = null)
    {
        $request = $this->request->getPost();
        $homestay = $this->homestayModel->list_by_owner_api(user()->id)->getRowArray();

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
            'name' => $request['name'],
            'description' => $request['description'],
            'image_url' => $gallery[0],
        ];

        foreach ($requestData as $key => $value) {
            if (empty($value)) {
                unset($requestData[$key]);
            }
        }

        $updateHS = $this->homestayExclusiveActivityModel->update_hea_api($requestData, $homestay['id'], $activity_id);

        if ($updateHS) {
            return redirect()->to(base_url('dashboard/exclusiveActivity'));
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function delete($homestay_id = null, $id = null)
    {
        $deleteS = $this->homestayExclusiveActivityModel->del_activity($homestay_id, $id);
        if ($deleteS) {
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
    public function getListActivity($homestay_id = null)
    {
        $homestay = $this->homestayModel->get_hs_by_id_api($homestay_id)->getRowArray();
        $contents = $this->homestayExclusiveActivityModel->get_list_hea_api($homestay_id)->getResultArray();
        for ($i = 0; $i < count($contents); $i++) {
            $getRID = $this->reservationHomestayActivityDetailModel->get_res_by_act_id($homestay_id, $contents[$i]['activity_id'])->getResultArray();
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
            $contents[$i]['id'] = $contents[$i]['activity_id'];
        }
        $data = [
            'title' => $homestay['name'],
            'category' => 'Homestay Exclusive Activity',
            'data' => $contents,
        ];

        $data['homestay_id'] = $homestay_id;

        dd($data);

        return view('web/homestay_activity_list', $data);
    }
}
