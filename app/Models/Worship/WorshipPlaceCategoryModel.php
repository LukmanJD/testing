<?php

namespace App\Models\Worship;

use CodeIgniter\Model;

class WorshipPlaceCategoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'worship_place_category';
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

    public function get_list_wscat_api()
    {
        $query = $this->db->table($this->table)
            ->select('id, name')
            ->get();
        return $query;
    }
    // public function get_list_hs_api() {
    //     //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
    //     $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
    //     $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
    //     $query = $this->db->table($this->table)
    //         ->select("{$columns}, rumah_gadang.lat, rumah_gadang.lng")
    //         ->from('village')
    //         ->where($vilGeom)
    //         ->get();
    //     return $query;
    // }

    // public function list_by_owner_api($id = null)
    // {
    //     //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
    //     $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.video_url";
    //     $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
    //     $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
    //     $query = $this->db->table($this->table)
    //         ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
    //         ->from('village')
    //         ->where($vilGeom)
    //         ->where('owner', $id)
    //         ->get();
    //     return $query;
    // }
}
