<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SouvenirProductDetail extends Migration
{
    public function up()
    {
        $fields = [
            'souvenir_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'souvenir_product_id' => [
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
        $this->forge->addPrimaryKey('souvenir_place_id');
        $this->forge->addPrimaryKey('souvenir_product_id');
        $this->forge->addForeignKey('souvenir_place_id', 'souvenir_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('souvenir_product_id', 'souvenir_product', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('souvenir_product_detail');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('souvenir_product_detail');
    }
}
