<?php

namespace App\Models\Souvenir;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class SouvenirPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'souvenir_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'phone', 'employee_name', 'geom', 'open', 'close', 'description'];

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
    public function get_list_sp_api()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.employee_name,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, souvenir_place.lat, souvenir_place.lng")
            // ->from('village')
            // ->where($vilGeom)
            ->get();
        return $query;
    }
    public function get_list_sp_by_vil_api($village_id = null)
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.employee_name,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, souvenir_place.lat, souvenir_place.lng, {$geoJson}")
            ->where('village_id', $village_id)
            // ->from('village')
            // ->where($vilGeom)
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null)
    {
        $query = $this->db->table($this->table)
            ->select('souvenir_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('account', 'souvenir_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_sp_by_id_api($id = null)
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.employee_name,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, souvenir_place.lat, souvenir_place.lng, {$geoJson}")
            // ->from('village')
            // ->where($vilGeom)
            ->where('souvenir_place.id', $id)
            ->get();
        return $query;
    }

    public function get_sp_by_radius_api($data = null)
    {
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $jarak = "(6371 * acos(cos(radians({$lat})) * cos(radians({$this->table}.lat)) * cos(radians({$this->table}.lng) - radians({$long})) + sin(radians({$lat}))* sin(radians({$this->table}.lat))))";
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.employee_name,{$this->table}.open,{$this->table}.close,{$this->table}.description";
        $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, souvenir_place.lat, souvenir_place.lng, {$jarak} as jarak")
            ->from('village')
            ->where($vilGeom)
            ->having(['jarak <=' => $radius])
            ->get();
        return $query;
    }

    public function get_sp_in_id_api($id = null)
    {
        $query = $this->db->table($this->table)
            ->select('souvenir_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->whereIn('souvenir_place.id', $id)
            ->join('account', 'souvenir_place.owner = account.id')
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
        $id = sprintf('S%01d', $count + 1);
        return $id;
    }

    public function add_sp_api($souvenir_place = null, $geojson = null)
    {
        foreach ($souvenir_place as $key => $value) {
            if (empty($value)) {
                unset($souvenir_place[$key]);
            }
        }
        $souvenir_place['created_at'] = Time::now();
        $souvenir_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($souvenir_place);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $souvenir_place['id'])
            ->update();
        return $query && $update;
    }

    public function update_sp_api($id = null, $souvenir_place = null, $geojson = null)
    {
        foreach ($souvenir_place as $key => $value) {
            if (empty($value)) {
                unset($souvenir_place[$key]);
            }
        }
        $souvenir_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($souvenir_place);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $id)
            ->update();
        return $query && $update;
    }
    public function get_sp_for_package($id = null)
    {
        // $id = implode(", ", $id);
        $query = $this->db->table($this->table)
            ->select('id AS id_object, name AS object_name')
            ->whereNotIN('id', $id)
            ->orderBy('object_name', 'ASC')
            ->get();
        return $query;
    }
    public function get_sp_by_vil_id($village_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('village_id', $village_id)
            ->get();
        return $query;
    }
}
