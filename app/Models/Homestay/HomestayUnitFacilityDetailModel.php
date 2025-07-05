<?php

namespace App\Models\Homestay;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use PhpParser\Node\Expr\AssignOp\Mul;

class HomestayUnitFacilityDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_unit_facility_detail';
    protected $returnType       = 'array';
    protected $allowedFields    = ['homestay_id', 'unit_type', 'unit_number', 'facility_id', 'description'];

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
    public function get_facility_id_by_hu_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $query = $this->db->table($this->table)
            ->select('facility_id')
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->get();
        return $query;
    }
    public function get_facility_by_hu_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $query = $this->db->table($this->table)
            ->select('homestay_unit_facility.id, homestay_unit_facility.name, homestay_unit_facility_detail.description')
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->join('homestay_unit_facility', 'homestay_unit_facility.id = homestay_unit_facility_detail.facility_id')
            ->get();
        return $query;
    }
    public function add_huf_api($facility = null, $homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $facility['homestay_id'] = $homestay_id;
        $facility['unit_type'] = $unit_type;
        $facility['unit_number'] = $unit_number;
        $facility['created_at'] = Time::now();
        $facility['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($facility);
        return $insert;
    }
    public function update_huf_api($facility = null, $homestay_id = null, $unit_type = null, $unit_number = null, $facility_id = null)
    {
        $facility['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->where('facility_id', $facility_id)
            ->update($facility);
        return $query;
    }
    public function delete_huf_by_id($homestay_id = null, $unit_type = null, $unit_number = null, $facility_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->where('facility_id', $facility_id)
            ->delete();
        return $query;
    }
    public function get_hs_id_by_unit($unit_type = null)
    {
        $query = $this->db->table($this->table)
            ->select('homestay_id')
            ->where('unit_type', $unit_type)
            ->groupBy('homestay_id')
            ->get();
        return $query;
    }
}
