<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class AttractionTicketPriceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'attraction_ticket_price';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'attraction_id', 'name', 'price'];

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

    public function get_new_id_api()
    {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        if ($lastId == null) {
            $count = 0;
        } else {
            $count = (int)substr($lastId['id'], 0);
        }
        $id = sprintf('%02d', $count + 1);
        return $id;
    }
    public function get_ticket_by_at_api($attraction_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('attraction_id', $attraction_id)
            ->get();
        return $query;
    }
    public function add_ticket_api($ticket = null)
    {
        $new_id = $this->get_new_id_api();
        $ticket['id'] = $new_id;
        $ticket['created_at'] = Time::now();
        $ticket['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($ticket);
        return $insert;
    }
    public function edit_ticket_api($ticket = null)
    {
        $ticket['updated_at'] = Time::now();
        $update = $this->db->table($this->table)
            ->where('id', $ticket['id'])
            ->update($ticket);

        return $update;
    }
}
