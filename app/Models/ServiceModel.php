<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'service';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'service_provider_id', 'name', 'price', 'unit_price'];

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

    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['id'], 0);
        }
        $id = sprintf('%02d', $count + 1);
        return $id;
    }
    public function get_service_by_sv_api($service_provider_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('service_provider_id', $service_provider_id)
            ->get();
        return $query;
    }
    public function add_sv_api($service = null)
    {
        $new_id = $this->get_new_id_api();
        $service['id'] = $new_id;
        $service['created_at'] = Time::now();
        $service['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($service);
        return $insert;
    }
    public function edit_sv_api($service = null)
    {
        $service['updated_at'] = Time::now();
        $update = $this->db->table($this->table)
            ->where('id', $service['id'])
            ->update($service);

        return $update;
    }
}
