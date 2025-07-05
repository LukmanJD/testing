<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HomestayGallery extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
            ],
            'homestay_id' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
            ],
            'url' => [
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('homestay_id', 'homestay', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('homestay_gallery');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('homestay_gallery');
    }
}
