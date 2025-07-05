<?php

namespace App\Models\Culinary;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CulinaryProductDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'culinary_product_detail';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['culinary_place_id', 'culinary_product_id', 'price', 'image_url', 'description'];

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

    public function add_cpr_api($product = null)
    {
        $product['created_at'] = Time::now();
        $product['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($product);
        return $insert;
    }
    public function get_product_id_by_sp_api($culinary_place_id = null)
    {
        $query = $this->db->table($this->table)
            ->select('culinary_product_id')
            ->where('culinary_place_id', $culinary_place_id)
            ->get();
        return $query;
    }
    public function get_product_by_sp_api($culinary_place_id = null)
    {
        $columns = "{$this->table}.culinary_place_id,{$this->table}.culinary_product_id,{$this->table}.price,{$this->table}.image_url,{$this->table}.description";
        $query = $this->db->table($this->table)
            ->select("{$columns}, culinary_product.name")
            ->where('culinary_place_id', $culinary_place_id)
            ->join('culinary_product', 'culinary_product.id = culinary_product_detail.culinary_product_id')
            ->get();
        return $query;
    }
    public function update_cpr_api($product = null, $culinary_place_id = null, $culinary_product_id = null)
    {
        $product['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('culinary_place_id', $culinary_place_id)
            ->where('culinary_product_id', $culinary_product_id)
            ->update($product);
        return $query;
    }
    public function delete_cpr_by_id($culinary_place_id = null, $culinary_product_id = null)
    {
        $query = $this->db->table($this->table)
            ->where('culinary_place_id', $culinary_place_id)
            ->where('culinary_product_id', $culinary_product_id)
            ->delete();
        return $query;
    }
}
