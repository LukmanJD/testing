<?php

namespace App\Models\Souvenir;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class SouvenirPlaceFacilityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'souvenir_place_facility';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name'];

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
    public function get_list_fc_api()
    {
        $query = $this->db->table($this->table)
            ->select('id, name')
            ->get();
        return $query;
    }
    public function add_spf_api($product = null)
    {
        $new_id = $this->get_new_id_api();
        $product['id'] = $new_id;
        $product['created_at'] = Time::now();
        $product['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($product);
        return $insert;
    }
    public function edit_spf_api($product = null)
    {
        $product['updated_at'] = Time::now();
        $update = $this->db->table($this->table)
            ->where('id', $product['id'])
            ->update($product);

        return $update;
    }
}
