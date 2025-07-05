<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class AttractionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'attraction';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'phone', 'open', 'close', 'employee_name', 'geom', 'description', 'video_url'];

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
    public function get_list_oat_api()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.price,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description,{$this->table}.attraction_category";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            // ->from('village')
            // ->where($vilGeom)
            ->where('attraction_category', '2')
            ->get();
        return $query;
    }

    public function get_uat_api()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.price,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description,{$this->table}.attraction_category";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        // $vilGeom = "village.id = '1' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            // ->from('village')
            // ->where($vilGeom)
            ->where('attraction_category', '1')
            ->get();
        return $query;
    }

    public function get_list_at_api()
    {
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            ->get();
        return $query;
    }

    public function get_list_at_api_mobile()
    {
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description, {$this->table}.attraction_category";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            ->get();
        return $query;
    }

    public function list_by_owner($id = null)
    {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('account', 'culinary_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_at_by_id_api($id = null)
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description,{$this->table}.video_url,{$this->table}.price,{$this->table}.attraction_category";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            ->where('attraction.id', $id)
            ->get();
        return $query;
    }

    public function get_at_in_id_api($id = null)
    {
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng")
            ->where('status', 'Ordinary')
            ->whereIn('id', $id)
            ->get();
        return $query;
    }

    public function get_at_by_name_api($name = null)
    {
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng")
            ->like('name', $name)
            ->where('status', 'Ordinary')
            ->get();
        return $query;
    }

    public function get_at_by_radius_api()
    {
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.phone,{$this->table}.open,{$this->table}.close,{$this->table}.employee_name,{$this->table}.description";
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$columns}, attraction.lat, attraction.lng, {$geoJson}")
            ->get();
        return $query;
    }

    public function get_list_fc_api()
    {
        $query = $this->db->table('attraction_facility')
            ->select('id, name')
            ->get();
        return $query;
    }

    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('created_at', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['id'], 1);
        }
        $id = sprintf('A%01d', $count + 1);
        return $id;
    }

    public function add_at_api($attraction = null, $geojson = null)
    {
        foreach ($attraction as $key => $value) {
            if (empty($value)) {
                unset($attraction[$key]);
            }
        }
        $attraction['created_at'] = Time::now();
        $attraction['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($attraction);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $attraction['id'])
            ->update();
        return $query && $update;
    }

    public function update_at_api($id = null, $attraction = null, $geojson = null)
    {
        // dd($attraction);
        foreach ($attraction as $key => $value) {
            if (empty($value)) {
                unset($attraction[$key]);
            }
        }
        $attraction['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($attraction);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $id)
            ->update();

        if (!isset($attraction['price'])) {
            $update = $this->db->table($this->table)
                ->set('price', '0')
                ->where('id', $id)
                ->update();
        }
        return $query && $update;
    }
    public function get_att_for_package($id = null)
    {
        // $id = implode(", ", $id);
        $query = $this->db->table($this->table)
            ->select('id AS id_object, name AS object_name, price_for_package')
            ->whereNotIN('id', $id)
            ->orderBy('object_name', 'ASC')
            ->get();
        return $query;
    }

    public function get_list_attcat_api()
    {
        $query = $this->db->table('attraction_category')
            ->select('id, name')
            ->get();
        return $query;
    }
}
