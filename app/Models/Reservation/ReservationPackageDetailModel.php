<?php

namespace App\Models\Reservation;

use CodeIgniter\Model;

class ReservationPackageDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'reservation_package_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['reservation_id', 'package_id', 'package_order', 'package_total_price'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function add_package($data)
    {
        return $this->insert($data);
    }

    public function get_packages_by_rid($reservation_id)
    {
        // This will fetch all packages associated with a reservation
        // You might want to join with the 'package' table to get more details
        return $this->where('reservation_id', $reservation_id)->findAll();
    }

    public function get_package_by_rid_pid($reservation_id, $package_id)
    {
        return $this->where('reservation_id', $reservation_id)
            ->where('package_id', $package_id)
            ->first();
    }

    public function get_total_price_by_rid($reservation_id)
    {
        $query = $this->db->table($this->table)
            ->selectSum('package_total_price')
            ->where('reservation_id', $reservation_id)
            ->get()
            ->getRow();

        return $query->package_total_price ?? 0;
    }

    public function delete_package($reservation_id, $package_id)
    {
        return $this->where('reservation_id', $reservation_id)
            ->where('package_id', $package_id)
            ->delete();
    }
}
