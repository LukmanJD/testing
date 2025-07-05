<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VillageModel;
use CodeIgniter\API\ResponseTrait;

class Tes extends BaseController
{
    public function index()
    {
        return view('tes_view');
    }
}