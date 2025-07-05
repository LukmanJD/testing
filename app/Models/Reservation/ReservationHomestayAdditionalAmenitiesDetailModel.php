<?php

namespace App\Models\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ReservationHomestayAdditionalAmenitiesDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reservation_homestay_additional_amenities_detail';
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
    public function get_haa_by_rid_api($homestay_id = null, $reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('homestay_id', $homestay_id)
            ->where('reservation_id', $reservation_id)
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

    public function del_haa_by_id_api($homestay_id = null, $additional_amenities_id = null, $reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $additional_amenities_id)
            ->where('reservation_id', $reservation_id)
            ->delete();
        return $query;
    }

    public function add_detail_haa($amenities)
    {
        $query = $this->db->table($this->table)
            ->insert($amenities);
        return $query;
    }
    public function get_res_by_act_id($homestay_id = null, $homestay_activity_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('reservation_id')
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $homestay_activity_id)
            ->groupBy('reservation_id')
            ->get();
        return $query;
    }

    public function get_amenities_stock_booked($homestay_id = null, $additional_amenities_id = null, $reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('sum(total_order)')
            ->where('homestay_id', $homestay_id)
            ->where('additional_amenities_id', $additional_amenities_id)
            ->whereIn('reservation_id', $reservation_id)
            ->get();
        return $query;
    }
}
