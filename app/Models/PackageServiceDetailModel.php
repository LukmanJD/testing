<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PackageServiceDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'package_service_detail';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['package_service_id', 'package_id', 'status'];

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

    public function get_list_service_by_id($homestay_id = null, $package_id = null)
    {
        $columns = "{$this->table}.package_id,{$this->table}.package_service_id,{$this->table}.status,{$this->table}.is_base_for_extend";
        $query = $this->db->table($this->table)
            ->select("{$columns}, package_service.name, package_service.price, package_service.category")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->join('package_service', 'package_service.id = package_service_detail.package_service_id')
            ->get();
        return $query;
    }
    public function get_sv_for_package($id = null)
    {
        $query = $this->db->table('package_service')
            ->select("id, name, price, category")
            ->whereNotIN('id', $id)
            ->orderBy('name', 'ASC')
            ->get();
        return $query;
    }
    public function add_package_service($package_service)
    {
        $insert = $this->db->table($this->table)
            ->insert($package_service);
        return $insert;
    }
    public function delete_ps_api($homestay_id = null, $package_id = null, $package_service_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('package_service_id', $package_service_id)
            ->delete();
        return $query;
    }
    public function get_ps_by_id_api($homestay_id = null, $package_id = null, $package_service_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('package_service_id', $package_service_id)
            ->get();
        return $query;
    }
}
