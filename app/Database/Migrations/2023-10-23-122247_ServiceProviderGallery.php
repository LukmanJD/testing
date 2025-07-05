<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ServiceProviderGallery extends Migration
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
        $this->forge->addForeignKey('service_provider_id', 'service_provider', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('service_provider_gallery');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('service_provider_gallery');
    }
}
