<?php

namespace App\Models\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use PhpParser\Node\Expr\AssignOp\Mul;

class ReservationHomestayUnitDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reservation_homestay_unit_detail';
    protected $returnType       = 'array';
    protected $allowedFields    = ['homestay_id', 'unit_type', 'unit_number', 'date', 'reservation_id'];

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
    public function get_unit_number_not_available($homestay_id = null, $unit_type = null, $date = null)
    {
        $query = $this->db->table($this->table)
            ->select("unit_number")
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('date', $date)
            ->get();
        return $query;
    }
    public function add_reservation_detail_api($homestay_id = null, $unit_type = null, $unit_number = null, $date = null, $reservation_id = null)
    {
        $reservationDetail['homestay_id'] = $homestay_id;
        $reservationDetail['unit_type'] = $unit_type;
        $reservationDetail['unit_number'] = $unit_number;
        $reservationDetail['date'] = $date;
        $reservationDetail['reservation_id'] = $reservation_id;

        $insert = $this->db->table($this->table)
            ->insert($reservationDetail);
        return $insert;
    }

    public function get_reservation_by_id($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('reservation_id', $reservation_id)
            ->get();
        return $query;
    }
    public function get_reservation_by_hs_api($homestay_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("reservation_id")
            ->where('homestay_id', $homestay_id)
            ->groupBy('reservation_id')
            ->orderBy('reservation_id', 'DESC')
            ->get();
        return $query;
    }
    public function delete_reserv_det_by_reserv_id($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('reservation_id', $reservation_id)
            ->delete();
        return $query;
    }
    public function get_reservation_by_huid($homestay_id = null, $unit_type = null, $unit_number = null)
    {
        $query = $this->db->table($this->table)
            ->select("reservation_id")
            ->where('homestay_id', $homestay_id)
            ->where('unit_type', $unit_type)
            ->where('unit_number', $unit_number)
            ->groupBy('reservation_id')
            ->get();
        return $query;
    }
    public function get_date_by_rid($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("date")
            ->where('reservation_id', $reservation_id)
            ->groupBy('date')
            ->get();
        return $query;
    }
    public function get_rid_in_date($date)
    {
        $query = $this->db->table($this->table)
            ->select("reservation_id")
            ->whereIn('date', $date)
            ->groupBy('reservation_id')
            ->get();
        return $query;
    }

    public function get_stay_in_dates($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("reservation_id, date")
            ->where('reservation_id', $reservation_id)
            ->groupBy('date')
            ->get();
        return $query;
    }

    public function get_date_disable()
    {
        $now = Time::now('Asia/Jakarta');
        $now = $now->toDateString();

        $query = $this->db->table($this->table)
            ->select("date")
            ->where('date >=', $now)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        return $query;
    }

    public function get_reseration_by_date($date = null)
    {
        $query = $this->db->table($this->table)
            ->select("reservation_id, date")
            ->where('date', $date)
            ->get();
        return $query;
    }

    public function get_hs_by_id($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('reservation_id', $reservation_id)
            ->get();
        return $query;
    }
}
