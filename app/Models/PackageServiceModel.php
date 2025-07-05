<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PackageServiceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'package_service';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'price', 'category'];

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

    public function get_psv_by_id($id)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('id', $id)
            ->get();
        return $query;
    }
}
