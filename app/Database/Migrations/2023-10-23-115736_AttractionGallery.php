<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttractionGallery extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
            ],
            'attraction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'url' => [
                'type' => 'TEXT',
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
        $this->forge->addForeignKey('attraction_id', 'attraction', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attraction_gallery');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('attraction_gallery');
    }
}
