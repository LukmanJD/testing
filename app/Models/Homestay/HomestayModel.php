<?php

namespace App\Models\Homestay;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class HomestayModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'geom', 'owner', 'open', 'close', 'description'];

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

    public function get_list_hs_api()
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
            ->get();
        return $query;
    }

    public function check_owner_has_homestay($id)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
            // ->from('village')
            // ->where($vilGeom)
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description,{$this->table}.category,{$this->table}.profil_link";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$geoJson}")
            // ->from('village')
            // ->where($vilGeom)
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['id'], 1);
        }
        $id = sprintf('H%02d', $count + 1);
        return $id;
    }

    public function add_hs_api($homestay = null, $geojson = null)
    {
        $homestay['created_at'] = Time::now();
        $homestay['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($homestay);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $homestay['id'])
            ->update();
        return $insert && $update;
    }

    public function get_hs_by_id_api($id = null)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.owner,{$this->table}.max_people_for_event,{$this->table}.description,{$this->table}.video_url";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, users.phone, homestay.category, homestay.lat, homestay.lng, {$geoJson}")
            // ->from('village')
            ->where('homestay.id', $id)
            ->join('users', 'users.id = homestay.owner', 'LEFT')
            // ->where($vilGeom)
            ->get();
        return $query;
    }

    public function get_hs_by_id_api_mobile($id = null)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.owner,{$this->table}.max_people_for_event,{$this->table}.description";
        // $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, users.phone, homestay.category, homestay.lat, homestay.lng")
            // ->from('village')
            ->where('homestay.id', $id)
            ->join('users', 'users.id = homestay.owner', 'LEFT')
            // ->where($vilGeom)
            ->get();
        return $query;
    }


    public function update_hs_api($id = null, $homestay = null, $geojson = null)
    {
        $homestay['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($homestay);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $id)
            ->update();
        return $query && $update;
    }
    public function getNameByUser($id = null)
    {
        $query = $this->db->table($this->table)
            ->select("name")
            ->where('owner', $id)
            ->get();
        return $query;
    }
    public function get_hs_by_radius_api($data = null)
    {
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $jarak = "(6371 * acos(cos(radians({$lat})) * cos(radians({$this->table}.lat)) * cos(radians({$this->table}.lng) - radians({$long})) + sin(radians({$lat}))* sin(radians({$this->table}.lat))))";
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng, {$jarak} as jarak")
            ->from('village')
            ->where($vilGeom)
            ->having(['jarak <=' => $radius])
            ->get();
        return $query;
    }
    public function get_hs_by_name_api($name = null)
    {
        //$coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng")
            ->like("{$this->table}.name", $name)
            ->get();
        return $query;
    }
    public function get_list_fc_api()
    {
        $query = $this->db->table('homestay_facility')
            ->select('id, name')
            ->get();
        return $query;
    }
    public function get_hs_in_id_api($id = null)
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.owner,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, homestay.lat, homestay.lng")
            ->whereIn('homestay.id', $id)
            ->get();
        return $query;
    }
    public function get_hs_owner_by_id($owner = null)
    {
        $query = $this->db->table('users')
            ->select("*")
            ->where('id', $owner)
            ->get();
        return $query;
    }
    public function get_hs_by_vil_id($village_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('village_id', $village_id)
            ->get();
        return $query;
    }
    public function get_hs_by_cat($village_id = null, $category = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('village_id', $village_id)
            ->where('category', $category)
            ->get();
        return $query;
    }
}
