<?php

namespace App\Models\Homestay;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class HomestayUnitGalleryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'homestay_unit_gallery';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'homestay_id', 'unit_type', 'unit_number', 'url'];

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
    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['id'], 0);
        }
        $id = sprintf('%03d', $count + 1);
        return $id;
    }

    public function get_gallery_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $query = $this->db->table($this->table)
            ->select('url')
            ->orderBy('id', 'ASC')
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->get();
        return $query;
    }

    public function add_gallery_api($homestay_id = null, $unit_type = null, $unit_number = null, $data = null)
    {
        $query = false;
        foreach ($data as $gallery) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'homestay_id' => $homestay_id,
                'unit_type' => $unit_type,
                'unit_number' => $unit_number,
                'url' => $gallery,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_gallery_api($homestay_id = null, $unit_type = null, $unit_number = null, $data = null)
    {
        $queryDel = $this->delete_gallery_api($homestay_id, $unit_type, $unit_number);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
        $queryIns = $this->add_gallery_api($homestay_id, $unit_type, $unit_number, $data);
        return $queryDel && $queryIns;
    }

    public function delete_gallery_api($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        return $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->delete();
    }
}
