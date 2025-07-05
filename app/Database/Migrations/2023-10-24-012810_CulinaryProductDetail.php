<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CulinaryProductDetail extends Migration
{
    public function up()
    {
        $fields = [
            'culinary_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'culinary_product_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'price' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'image_url' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ];

        $this->db->disableForeignKeyChecks();
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('culinary_place_id');
        $this->forge->addPrimaryKey('culinary_product_id');
        $this->forge->addForeignKey('culinary_place_id', 'culinary_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('culinary_product_id', 'culinary_product', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('culinary_product_detail');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('culinary_product_detail');
    }
}
