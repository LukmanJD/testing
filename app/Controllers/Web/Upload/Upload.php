<?php

namespace App\Controllers\Web\Upload;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Upload extends ResourceController
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var IncomingRequest
     */
    protected $request;

    protected $helpers = ['filesystem'];
    use ResponseTrait;

    public function avatar()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $img = $this->request->getFile('avatar');
        if ($img != null) {
            $originalName = $img->getName();
            if (!$img->hasMoved() && $originalName != 'default.jpg') {
                $file = $img->getRandomName();
                $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                if ($createdFolder) {
                    $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                    return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($folder);
                }
                $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody($error);
            }
            return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($originalName);
        }
        return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody("file is null, upload failed");
    }

    public function remove()
    {
        $folder = $this->request->getBody();
        if ($folder != 'default.jpg') {
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $deleteFile = delete_files($filepath);
            if (!$deleteFile) {
                return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody("Failed deleting files in directory: " . $filepath);
            }
            $removeDir = rmdir($filepath);
            if (!$removeDir) {
                return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody("Failed deleting directory: " . $filepath);
            }
            return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($filepath);
        }
        return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($folder);
    }

    public function photo()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $files = $this->request->getFileMultiple('gallery');
        if ($files != null) {
            foreach ($files as $img) {
                if (!$img->hasMoved()) {
                    $file = $img->getRandomName();
                    $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                    if ($createdFolder) {
                        $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                        return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($folder);
                    }
                    $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                    return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody($error);
                }
            }
            return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody('');
        }
        return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody("file is null, upload failed");
    }

    public function video()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $img = $this->request->getFile('video');
        if ($img != null) {
            if (!$img->hasMoved()) {
                $file = $img->getRandomName();
                $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                if ($createdFolder) {
                    $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                    return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody($folder);
                }
                $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody($error);
            }
            return $this->response->setStatusCode(200)->setHeader('Content-Type', 'text/plain')->setBody('');
        }
        return $this->response->setStatusCode(400)->setHeader('Content-Type', 'text/plain')->setBody("file is null, upload failed");
    }
}
