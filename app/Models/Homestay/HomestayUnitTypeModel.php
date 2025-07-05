<?php

namespace App\Models\Homestay;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayUnitTypeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_unit_type';
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

    public function get_list_hu_type_api()
    {
        $columns = "{$this->table}.homestay_id,{$this->table}.unit_type,{$this->table}.unit_number,{$this->table}.name,{$this->table}.price,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("id, name")
            ->get();
        return $query;
    }
}
