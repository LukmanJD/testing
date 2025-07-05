<?php

namespace App\Models\Reservation;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use PhpParser\Node\Expr\AssignOp\Mul;

class ReservationHomestayUnitDetailBackUpModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reservation_homestay_unit_detail_backup';
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
    public function add_reservation_detail_api($reservationDetail = null)
    {
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

    public function get_hs_by_id($reservation_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('reservation_id', $reservation_id)
            ->get();
        return $query;
    }
}
