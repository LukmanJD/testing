<?php

namespace App\Models\Homestay;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayAdditionalAmenitiesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_additional_amenities';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'homestay_id', 'name', 'description', 'image_url'];

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

    public function get_list_haa_api($homestay_id)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
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

    public function get_new_id_api($homestay_id = null)
    {
        $lastId = $this->db->table($this->table)->select('additional_amenities_id')->where('homestay_id', $homestay_id)->orderBy('additional_amenities_id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['additional_amenities_id'], 0);
        }
        $id = sprintf('%02d', $count + 1);
        return $id;
    }

    public function add_haa_api($additionalAmenities = null)
    {
        $new_id = $this->get_new_id_api($additionalAmenities['homestay_id']);
        $additionalAmenities['additional_amenities_id'] = $new_id;
        $additionalAmenities['created_at'] = Time::now();
        $additionalAmenities['updated_at'] = Time::now();
        unset($additionalAmenities['gallery']);
        $insert = $this->db->table($this->table)
            ->insert($additionalAmenities);
        return $insert;
    }

    public function get_haa_by_id_api($homestay_id = null, $additional_amenities_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $additional_amenities_id)
            ->get();
        return $query;
    }

    public function update_haa_api($additionalAmenities = null, $homestay_id = null, $activity_id = null)
    {
        $additionalAmenities['updated_at'] = Time::now();
        unset($additionalAmenities['gallery']);
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $activity_id)
            ->update($additionalAmenities);
        return $query;
    }
    public function get_haa_for_res($id = null, $homestay_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_type', '1')
            ->whereNotIN('additional_amenities_id', $id)
            ->orderBy('name', 'ASC')
            ->get();
        return $query;
    }
    public function del_activity($homestay_id = null, $activity_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $activity_id)
            ->delete();
        return $query;
    }
    public function get_haa_for_event($homestay_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_type', '2')
            ->get();
        return $query;
    }
}
