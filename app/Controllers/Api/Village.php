<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\VillageModel;
use CodeIgniter\API\ResponseTrait;

class Village extends BaseController
{
    use ResponseTrait;
    protected $villageModel;
    public function __construct()
    {
        $this->villageModel = new VillageModel();
    }

    public function getData()
    {
        $request = $this->request->getPost();
        $village = $request['village'];
        $content = $this->villageModel->get_village_data($village)->getRowArray();
        $response = [
            'data' => $content,
            'status' => 200,
            'message' => [
                "Success get village data"
            ]
        ];
        return $this->respond($response);
    }
    public function getTouristVillageData()
    {
        $content = $this->villageModel->get_tourist_area_data()->getRowArray();
        $response = [
            'data' => $content,
            'status' => 200,
            'message' => [
                "Success get village data"
            ]
        ];
        return $this->respond($response);
    }
    public function getUniqueAttData()
    {
        // $content = $this->villageModel->get_tourist_area_data()->getRowArray();
        $geoJson = json_decode($this->villageModel->get_unique_att_data()->getRowArray()['geoJson']);
        $content = [
            'type' => 'Feature',
            'geometry' => $geoJson,
            'properties' => [
                'id' => 'L01',
                'name' => 'Lembah Harau Tourist Area',
            ]
        ];
        $response = [
            'data' => $content,
            'status' => 200,
            'message' => [
                "Success get tourist area data"
            ]
        ];
        return $this->respond($response);
    }
    public function getVillagesData()
    {
        $contents = $this->villageModel->get_village_list()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Villages"
            ]
        ];
        return $this->respond($response);
    }
    public function getSubdistrictsData()
    {
        $contents = $this->villageModel->get_subdistrict_list()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Subdistricts"
            ]
        ];
        return $this->respond($response);
    }
    public function getCitiesData()
    {
        $contents = $this->villageModel->get_city_list()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Cities"
            ]
        ];
        return $this->respond($response);
    }
    public function getProvincesData()
    {
        $contents = $this->villageModel->get_province_list()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Provincies"
            ]
        ];
        return $this->respond($response);
    }
    public function getCountriesData()
    {
        $contents = $this->villageModel->get_country_list()->getResult();

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Countries"
            ]
        ];
        return $this->respond($response);
    }
    public function selectVillage()
    {
        $contents = $this->villageModel->village_list()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Village"
            ]
        ];
        return $this->respond($response);
    }
    public function getVillageGeom($id = null)
    {
        $contents = $this->villageModel->get_village_data($id)->getRowArray();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Villages"
            ]
        ];
        return $this->respond($response);
    }
    public function getSocials()
    {
        $contents = $this->villageModel->check_village()->getRowArray();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get Village data"
            ]
        ];
        return $this->respond($response);
    }
}
