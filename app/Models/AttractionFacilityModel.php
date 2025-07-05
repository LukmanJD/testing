<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class AttractionFacilityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'attraction_facility';
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
    public function add_fc_api($facility = null)
    {
        $new_id = $this->get_new_id_api();
        $facility['id'] = $new_id;
        $facility['created_at'] = Time::now();
        $facility['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($facility);
        return $insert;
    }
    public function edit_fc_api($product = null)
    {
        $product['updated_at'] = Time::now();
        $update = $this->db->table($this->table)
            ->where('id', $product['id'])
            ->update($product);

        return $update;
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
