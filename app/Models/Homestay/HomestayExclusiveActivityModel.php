<?php

namespace App\Models\Homestay;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayExclusiveActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_exclusive_activity';
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

    public function get_list_hea_api($homestay_id)
    {
        $columns = "{$this->table}.activity_id,{$this->table}.homestay_id,{$this->table}.name,{$this->table}.price,{$this->table}.is_daily,{$this->table}.description,{$this->table}.image_url";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
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
        $lastId = $this->db->table($this->table)->select('activity_id')->where('homestay_id', $homestay_id)->orderBy('activity_id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['activity_id'], 0);
        }
        $id = sprintf('%03d', $count + 1);
        return $id;
    }

    public function add_hea_api($homestayActivity = null)
    {
        $new_id = $this->get_new_id_api($homestayActivity['homestay_id']);
        $homestayActivity['activity_id'] = $new_id;
        $homestayActivity['created_at'] = Time::now();
        $homestayActivity['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($homestayActivity);
        return $insert;
    }

    public function get_hea_by_id_api($homestay_id = null, $activity_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('activity_id', $activity_id)
            ->get();
        return $query;
    }

    public function update_hea_api($activity = null, $homestay_id = null, $activity_id = null)
    {
        $activity['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('activity_id', $activity_id)
            ->update($activity);
        return $query;
    }
    public function get_act_for_package($id = null)
    {
        // $id = implode(", ", $id);
        $query = $this->db->table($this->table)
            ->select('id AS id_object, name AS object_name')
            ->whereNotIN('id', $id)
            ->orderBy('object_name', 'ASC')
            ->get();
        return $query;
    }
    public function del_activity($homestay_id = null, $activity_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('activity_id', $activity_id)
            ->delete();
        return $query;
    }
}
