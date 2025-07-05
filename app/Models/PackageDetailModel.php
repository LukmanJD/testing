<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PackageDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'package_detail';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['package_id', 'day', 'activity', 'activity_type', 'id_object', 'description'];

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

    public function get_new_activity($homestay_id = null, $package_id = null, $day = null)
    {
        $lastId = $this->db->table($this->table)
            ->select('activity')
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('day', $day)
            ->orderBy('activity', 'ASC')
            ->get()
            ->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = $lastId['activity'];
        }
        $activity = sprintf($count + 1);
        return $activity;
    }
    public function add_pd_api($package_detail = null)
    {
        $insert = $this->db->table($this->table)
            ->insert($package_detail);
        return $insert;
    }
    public function get_pd_by_id($homestay_id = null, $package_id = null, $day = null, $activity = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('day', $day)
            ->where('activity', $activity)
            ->get();
        return $query;
    }
    public function get_pd_by_pacakage_id_api($homestay_id = null, $package_id = null)
    {
        $columns = "{$this->table}.package_id,{$this->table}.day,{$this->table}.activity,{$this->table}.activity_type,{$this->table}.id_object,{$this->table}.description,{$this->table}.is_base_for_extend";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->get();
        return $query;
    }
    public function get_list_activity_by_day($homestay_id = null, $package_id = null, $day = null)
    {
        $columns = "{$this->table}.homestay_id,{$this->table}.package_id,{$this->table}.day,{$this->table}.activity,{$this->table}.activity_type,{$this->table}.id_object,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}")
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('day', $day)
            ->get();
        return $query;
    }
    public function delete_pd_api($homestay_id = null, $package_id = null, $day = null, $activity = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('package_id', $package_id)
            ->where('day', $day)
            ->where('activity', $activity)
            ->delete();
        return $query;
    }
    public function get_pid_by_day($homestay_id = null, $day_of_stay = null)
    {
        $query = $this->db->table($this->table)
            ->select("package_id, max(day) AS total_day")
            ->where('homestay_id', $homestay_id)
            ->groupBy('package_id')
            ->get();
        return $query;
    }
}
