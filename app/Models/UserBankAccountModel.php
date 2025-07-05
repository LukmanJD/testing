<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class UserBankAccountModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_bank_account';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'bank_name', 'bank_code', 'account_number', 'account_name'];

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

    public function get_user_bank_account($user_id = null)
    {
        $query = $this->db->table($this->table)
            ->select("*")
            ->where('user_id', $user_id)
            ->get();
        return $query;
    }

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

    public function add_user_bank_account($user_bank_account = null)
    {
        $new_id = $this->get_new_id_api();

        $user_bank_account['id'] = $new_id;

        $query = $this->db->table($this->table)->insert($user_bank_account);

        return $query;
    }
    public function update_user_bank_account($user_bank_account = null, $id = null)
    {
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($user_bank_account);
        return $query;
    }
}
