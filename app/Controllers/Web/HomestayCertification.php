<?php

namespace App\Controllers\Web;

use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\API\ResponseTrait;

use App\Models\HomestayCertificationModel;

class HomestayCertification extends ResourcePresenter
{
    use ResponseTrait;

    protected $homestayCertificationModel;

    protected $helpers = ['auth', 'url', 'filesystem'];

    public function __construct()
    {
        $this->homestayCertificationModel = new HomestayCertificationModel();
    }

    public function create()
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

        $request['image_url'] = $gallery[0];
        $addHS = $this->homestayCertificationModel->add_hc($request);

        if ($addHS) {
            return redirect()->to(base_url('dashboard/homestay') . '/' . $request['homestay_id']);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function update($certification_id = null)
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

        $request['image_url'] = $gallery[0];
        $updateHS = $this->homestayCertificationModel->update_hc($request, $request['homestay_id'], $certification_id);

        if ($updateHS) {
            return redirect()->to(base_url('dashboard/homestay') . '/' . $request['homestay_id']);
        } else {
            return redirect()->back()->withInput();
        }
    }
    public function delete($certification_id = null)
    {
        $request = $this->request->getPost();

        $deleteS = $this->homestayCertificationModel->del_hc($request['homestay_id'], $certification_id);
        if ($deleteS) {
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "certification not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
}
