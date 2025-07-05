<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PackageDayModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'package_day';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['package_id', 'day', 'description'];

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

    public function get_new_day($homestay_id = null, $package_id = null)
    {
        $lastId = $this->db->table($this->table)
            ->select('day')
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->orderBy('day', 'ASC')
            ->get()
            ->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = $lastId['day'];
        }
        $day = sprintf($count + 1);
        return $day;
    }
    public function add_pd_api($package_day = null)
    {
        $day = $this->get_new_day($package_day['homestay_id'], $package_day['package_id']);
        $package_day['day'] = $day;

        $insert = $this->db->table($this->table)
            ->insert($package_day);
        return $insert;
    }
    public function add_epd_api($package_day = null)
    {
        $insert = $this->db->table($this->table)
            ->insert($package_day);
        return $insert;
    }
    public function get_pd_by_pacakage_id_api($homestay_id = null, $package_id = null)
    {
        $columns = "{$this->table}.package_id,{$this->table}.day,{$this->table}.description,{$this->table}.is_base_for_extend";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->get();
        return $query;
    }
    public function delete_pd_api($homestay_id = null, $package_id = null, $day = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('day', $day)
            ->delete();
        return $query;
    }
}
