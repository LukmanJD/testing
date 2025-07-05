<?php

namespace App\Models\Homestay;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class HomestayFacilityDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_facility_detail';
    protected $returnType       = 'array';
    protected $allowedFields    = ['homestay_id', 'facility_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // API
    public function get_facility_by_hs_api($homestay_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('homestay_facility.name')
            ->where('homestay_id', $homestay_id)
            ->join('homestay_facility', 'homestay_facility_detail.facility_id = homestay_facility.id')
            ->get();
        return $query;
    }

    public function get_facility_by_fc_api($facility_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('facility_id', $facility_id)
            ->get();
        return $query;
    }


    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        $count = (int)substr($lastId['id'], 0);
        $id = sprintf('%03d', $count + 1);
        return $id;
    }

    public function add_facility_api($id = null, $data = null)
    {
        $query = false;
        foreach ($data as $facility) {
            $content = [
                'homestay_id' => $id,
                'facility_id' => $facility,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_facility_api($id = null, $data = null)
    {
        $queryDel = $this->db->table($this->table)->delete(['homestay_id' => $id]);
        $queryIns = $this->add_facility_api($id, $data);
        return $queryDel && $queryIns;
    }
}
