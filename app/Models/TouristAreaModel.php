<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class TouristAreaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tourist_area';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'open', 'close', 'ticket_price', 'contact_person',  'description', 'video_url', 'geom', 'lat', 'lng', 'facebook', 'instagram', 'youtube', 'tiktok'];

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

    public function add_tourist_area($tourist_area = null, $geojson = null)
    {
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->set('lat', $tourist_area['lat'])
            ->set('lng', $tourist_area['lng'])
            ->where('id', 'L1')
            ->update();
        return $update;
    }
    public function get_tourist_area()
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('id', 'L1')
            ->get();    
        return $query;
    }
    public function get_tourist_area_gallery()
    {
        $query = $this->db->table('tourist_area_gallery')
            ->select("url")
            ->where('tourist_area_id', '1')
            ->get();
        return $query;
    }
}
