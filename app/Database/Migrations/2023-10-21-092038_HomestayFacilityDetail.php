<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HomestayFacilityDetail extends Migration
{
    public function up()
    {
        $fields = [
            'homestay_id' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
            ],
            'facility_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
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
        $this->forge->addPrimaryKey('homestay_id');
        $this->forge->addPrimaryKey('facility_id');
        $this->forge->addForeignKey('homestay_id', 'homestay', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('facility_id', 'homestay_facility', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('homestay_facility_detail');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('homestay_facility_detail');
    }
}
