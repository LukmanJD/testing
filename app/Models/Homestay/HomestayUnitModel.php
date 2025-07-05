<?php

namespace App\Models\Homestay;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayUnitModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_unit';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['homestay_id', 'unit_type', 'unit_number', 'name', 'price', 'description'];

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

    public function get_list_hu_api($homestay_id)
    {
        $columns = "{$this->table}.homestay_id,{$this->table}.unit_type,{$this->table}.unit_number,{$this->table}.name,{$this->table}.price,{$this->table}.capacity,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->orderBy('created_at', 'ASC')
            ->get();
        return $query;
    }

    public function check_owner_has_homestay($id)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.video_url";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
            ->from('village')
            ->where($vilGeom)
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.video_url";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
            ->from('village')
            ->where($vilGeom)
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function get_new_id_api($homestay_id = null, $unit_type = null)
    {
        $lastId = $this->db->table($this->table)
            ->select('unit_number')
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)$lastId['unit_number'];
        }

        $id = sprintf($count + 1);
        return $id;
    }

    public function add_hs_api($homestayUnit = null)
    {
        $homestayUnit['created_at'] = Time::now();
        $homestayUnit['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($homestayUnit);
        return $insert;
    }

    public function get_hu_by_id_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {

        $columns = "{$this->table}.homestay_id,{$this->table}.unit_type,{$this->table}.unit_number,{$this->table}.name,{$this->table}.price,{$this->table}.capacity,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay_unit_type.name AS unit")
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->join('homestay_unit_type', 'homestay_unit_type.id = homestay_unit.unit_type')
            ->get();
        return $query;
    }

    public function update_hs_api($homestay_id = null, $unit_type = null, $unit_number = null, $homestayUnit = null)
    {
        $homestayUnit['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->update($homestayUnit);
        return $query;
    }

    public function delete_hu_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->delete();
        return $query;
    }
    public function get_hu_in_number($homestay_id = null, $unit_type = null, $id = null)
    {
        $columns = "{$this->table}.homestay_id,{$this->table}.unit_type,{$this->table}.unit_number,{$this->table}.name,{$this->table}.price,{$this->table}.capacity,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->whereNotIN('unit_number', $id)
            ->orderBy('created_at', 'ASC')
            ->get();
        return $query;
    }
    public function get_hs_by_hsid_unittype($homestay_id = null, $unit_type = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->get();
        return $query;
    }
}
