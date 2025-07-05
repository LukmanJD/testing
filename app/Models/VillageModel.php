<?php

namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class VillageModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'village';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'district', 'geom', 'geom_file'];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // API
    public function get_sumpur_api()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $query = $this->db->table($this->table)
            ->select("id, name")
            ->where('id', '1')
            ->get();
        return $query;
    }

    public function get_desa_wisata_api()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $query = $this->db->table($this->table)
            ->select("id, name")
            ->where('id', '2')
            ->get();
        return $query;
    }

    public function get_geoJson_api($id = null)
    {
        $geoJson = "ST_AsGeoJSON({$this->table}.geom) AS geoJson";
        $query = $this->db->table($this->table)
            ->select("{$geoJson}")
            ->where('id', $id)
            ->get();
        return $query;
    }

    public function add_village($village = null, $geojson = null)
    {
        $insert = $this->db->table($this->table)
            ->insert($village);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $village['id'])
            ->update();
        return $insert && $update;
    }
    public function get_kab_kota()
    {
        // $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $query = $this->db->table('kab_kota')
            ->select("id, name")
            ->where('id', 'K11')
            ->get();
        return $query;
    }
    public function get_geoJson_api_zzz($id = null)
    {
        $geoJson = "ST_AsGeoJSON(kab_kota.geom) AS geoJson";
        $query = $this->db->table('kab_kota')
            ->select("{$geoJson}")
            ->where('id', $id)
            ->get();
        return $query;
    }

    public function get_village_data($id = null)
    {
        $query = $this->db->table($this->table)
            ->select("id, name, geom_file")
            ->where('id', $id)
            ->get();
        return $query;
    }
    public function get_tourist_area_data()
    {
        $query = $this->db->table('village')
            ->select("*")
            ->where('selected', '1')
            ->get();
        return $query;
    }
    public function get_unique_att_data()
    {
        $geoJson = "ST_AsGeoJSON(geom) AS geoJson";
        $query = $this->db->table('attraction')
            ->select("{$geoJson}")
            ->where('id', 'A7')
            ->get();
        return $query;
    }
    public function get_village_list()
    {
        $query = $this->db->table($this->table)
            ->select("id, name, geom_file")
            ->where("id NOT IN ('1')")
            ->get();
        return $query;
    }
    public function get_subdistrict_list()
    {
        $query = $this->db->table('subdistrict')
            ->select("id, name, geom")
            ->where("id NOT IN ('S05')")
            ->get();
        return $query;
    }
    public function get_city_list()
    {
        $query = $this->db->table('city')
            ->select("id, name, geom")
            ->get();
        return $query;
    }
    public function get_province_list()
    {
        $query = $this->db->table('province')
            ->select("id, name, geom")
            ->where("id NOT IN ('P03')")
            ->get();
        return $query;
    }
    public function get_country_list()
    {
        $query = $this->db->table('country')
            ->select("id, name, geom")
            ->where("id NOT IN ('N03')")
            ->get();
        return $query;
    }

    public function check_village()
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('selected', '1')
            ->get();

        return $query;
    }

    public function village_list()
    {
        $query = $this->db->table($this->table)
            ->select("id, name, geom_file")
            ->orderBy('name', 'ASC')
            ->get();
        return $query;
    }

    public function update_village($id = null, $data = null)
    {
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($data);

            if (!isset ($data['ticket_price'])) {
                $this->db->table($this->table)
                ->set('ticket_price', '0')
                ->where('id', $id)
                ->update();
            }
        return $query;
    }

    public function get_announcement_info()
    {
        $query = $this->db->table('announcement')
            ->select("id, admin_id, announcement, status")
            ->where('status', 1)
            ->get();
        return $query;
    }

    public function get_announcement_all()
    {
        $query = $this->db->table('announcement')
            ->select("id, admin_id, announcement, status")
            ->get();
        return $query;
    }

    public function get_new_announcement_id()
    {
        $builder = $this->db->table('announcement');     
        $lastId = $builder->select('id')->orderBy('id', 'DESC')->get()->getFirstRow('array');
        
        if ($lastId) {
            $count = (int)substr($lastId['id'], 2);
            $newCount = $count + 1; 
        } else {
            $newCount = 1; 
        }
        
        $id = sprintf('L%04d', $newCount); 
        return $id;
    }

    public function add_new_announcement($announcement = null)
    {
       
        $insert = $this->db->table('announcement')
            ->insert($announcement);
        return $insert;
    }

    public function update_announcement ($id = null, $announcement = null)
    {
        foreach ($announcement as $key => $value) {
            if (empty($value)) {
                unset($announcement[$key]);
            }
        }
        
        $query = $this->db->table('announcement')
            ->where('id', $id)
            ->update($announcement);
        return $query;
    }

    public function delete_announcement($id = null)
    {
        $query = $this->db->table('announcement')
        ->where('id', $id)
        ->delete();
    return $query;
    }
}
