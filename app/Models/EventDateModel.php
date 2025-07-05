<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class EventDateModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'event_date';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['event_id', 'date'];

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

    public function add_date_api($date = null)
    {
        $insert = $this->db->table($this->table)
            ->insert($date);
        return $insert;
    }
    public function get_list_date_api($event_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('date')
            ->where('event_id', $event_id)
            ->get();
        return $query;
    }
    public function delete_date($event_id = null, $date = null)
    {
        $query = $this->db->table($this->table)
            ->where('event_id', $event_id)
            ->where('date', $date)
            ->delete();
        return $query;
    }
    public function get_upcoming_ev_date($event_id = null, $date = null)
    {
        $query = $this->db->table($this->table)
            ->where('event_id', $event_id)
            ->where('date >', $date)
            ->get();
        return $query;
    }
    public function get_last_ev_date($event_id = null, $date = null)
    {
        $query = $this->db->table($this->table)
            ->where('event_id', $event_id)
            ->where('date <=', $date)
            ->get();
        return $query;
    }
}
