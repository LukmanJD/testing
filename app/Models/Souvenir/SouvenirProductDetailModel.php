<?php

namespace App\Models\Souvenir;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class SouvenirProductDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'souvenir_product_detail';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['souvenir_place_id', 'souvenir_product_id', 'price', 'image_url', 'description'];

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

    public function add_spr_api($product = null)
    {
        $product['created_at'] = Time::now();
        $product['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($product);
        return $insert;
    }
    public function get_product_id_by_sp_api($souvenir_place_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('souvenir_product_id')
            ->where('souvenir_place_id', $souvenir_place_id)
            ->get();
        return $query;
    }
    public function get_product_by_sp_api($souvenir_place_id = null)
    {
        $columns = "{$this->table}.souvenir_place_id,{$this->table}.souvenir_product_id,{$this->table}.price,{$this->table}.image_url,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, souvenir_product.name")
            ->where('souvenir_place_id', $souvenir_place_id)
            ->join('souvenir_product', 'souvenir_product.id = souvenir_product_detail.souvenir_product_id')
            ->get();
        return $query;
    }
    public function update_spr_api($product = null, $souvenir_place_id = null, $souvenir_product_id = null)
    {
        $product['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('souvenir_place_id', $souvenir_place_id)
            ->where('souvenir_product_id', $souvenir_product_id)
            ->update($product);
        return $query;
    }
    public function delete_spr_by_id($souvenir_place_id = null, $souvenir_product_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('souvenir_place_id', $souvenir_place_id)
            ->where('souvenir_product_id', $souvenir_product_id)
            ->delete();
        return $query;
    }
}
