<?php

namespace App\Models\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ReservationHomestayActivityDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reservation_homestay_activity_detail';
    protected $returnType       = 'array';
    protected $allowedFields    = ['reservation_id', 'homestay_activity_detail'];

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
    public function get_activity_by_rid_api($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            // ->where('reservation_homestay_activity_detail.homestay_id', $homestay_id)
            ->where('reservation_id', $reservation_id)
            // ->join('homestay_exclusive_activity', 'homestay_exclusive_activity.activity_id = reservation_homestay_activity_detail.homestay_activity_id', 'LEFT')
            ->get();
        return $query;
    }

    public function del_activity_by_rid_api($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('reservation_id', $reservation_id)
            ->delete();
        return $query;
    }

    public function add_detail_res_act($homestay_id = null, $reservation_id = null, $homestay_activity_id = null)
    {
        $data = [
            'homestay_id' => $homestay_id,
            'homestay_activity_id' => $homestay_activity_id,
            'reservation_id' => $reservation_id,
        ];

        $query = $this->db->table($this->table)
            ->insert($data);
        return $query;
    }
    public function get_res_by_act_id($homestay_id = null, $homestay_activity_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('reservation_id')
            ->where('homestay_id', $homestay_id)
            ->where('homestay_activity_id', $homestay_activity_id)
            ->groupBy('reservation_id')
            ->get();
        return $query;
    }
}
