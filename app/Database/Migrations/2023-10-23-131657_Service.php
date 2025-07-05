<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Service extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'service_provider_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'price' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'unit_price' => [
                'type' => 'varchar',
                'constraint' => 25,
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
        $this->forge->addForeignKey('service_provider_id', 'service_provider', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('service');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('service');
    }
}
