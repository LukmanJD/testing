<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Homestay extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'geom' => [
                'type' => 'GEOMETRY',
                'null' => true,
            ],
            'lat' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
            ],
            'lng' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
            ],
            'owner' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'open' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'close' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'video_url' => [
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
        $this->forge->addForeignKey('owner', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('homestay');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('homestay');
    }
}
