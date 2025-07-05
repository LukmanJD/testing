<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayCertificationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_certification';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['homestay_id', 'certification_id', 'certification_name', 'certification_num', 'certifying_agency', 'date', 'description', 'image_url'];

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

    public function get_new_id_api($homestay_id = null)
    {
        $lastId = $this->db->table($this->table)->select('certification_id')->where('homestay_id', $homestay_id)->orderBy('certification_id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['certification_id'], 0);
        }
        $id = sprintf('%03d', $count + 1);
        return $id;
    }

    public function add_hc($homestayCertification = null)
    {
        $new_id = $this->get_new_id_api($homestayCertification['homestay_id']);

        $homestayCertification['certification_id'] = $new_id;
        unset($homestayCertification['gallery']);

        $insert = $this->db->table($this->table)
            ->insert($homestayCertification);
        return $insert;
    }

    public function get_list_homestay_certification($homestay_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->get();
        return $query;
    }
    public function update_hc($homestayCertification = null, $homestay_id = null, $certification_id = null)
    {
        unset($homestayCertification['gallery']);
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('certification_id', $certification_id)
            ->update($homestayCertification);
        return $query;
    }

    public function del_hc($homestay_id = null, $certification_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('certification_id', $certification_id)
            ->delete();
        return $query;
    }
}
