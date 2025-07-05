<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PackageModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'package';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'homestay_id', 'name', 'min_capacity', 'brochure_url', 'description', 'price', 'is_custom'];

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
        $columns = "{$this->table}.id,{$this->table}.homestay_id,{$this->table}.name,{$this->table}.description,{$this->table}.image_url";
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

    public function list_by_homestay_api($homestay_id = null)
    {
        $columns = "{$this->table}.homestay_id,{$this->table}.package_id,{$this->table}.name,{$this->table}.min_capacity,{$this->table}.brochure_url,{$this->table}.description,{$this->table}.price,{$this->table}.is_custom";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->orderBy('is_custom')
            ->get();
        return $query;
    }

    public function get_new_id_api($homestay_id = null)
    {
        $lastId = $this->db->table($this->table)->select('package_id')->where('homestay_id', $homestay_id)->orderBy('homestay_id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['package_id'], 1);
        }
        $id = sprintf('P%03d', $count + 1);
        return $id;
    }

    public function add_package_api($package = null)
    {
        $package['created_at'] = Time::now();
        $package['updated_at'] = Time::now();

        $insert = $this->db->table($this->table)
            ->insert($package);
        return $insert;
    }

    public function get_package_by_id_api($homestay_id = null, $package_id = null)
    {

        $columns = "{$this->table}.package_id,{$this->table}.homestay_id,{$this->table}.name,{$this->table}.min_capacity,{$this->table}.brochure_url,{$this->table}.description,{$this->table}.price,{$this->table}.is_custom";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->get();
        return $query;
    }

    public function update_hea_api($activity = null, $id = null)
    {
        $activity['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($activity);
        return $query;
    }

    public function update_package_api($package = null, $homestay_id = null, $package_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->update($package);
        return $query;
    }

    public function check_package_api($homestay_id = null, $package_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->get();
        return $query;
    }
    public function set_price($price = null, $homestay_id = null, $package_id = null)
    {
        $package['price'] = $price;
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->update($package);
        return $query;
    }
    public function del_package($homestay_id = null, $package_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->delete();
        return $query;
    }
}
