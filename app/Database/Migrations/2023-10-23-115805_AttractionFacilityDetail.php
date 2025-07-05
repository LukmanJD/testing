<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttractionFacilityDetail extends Migration
{
    public function up()
    {
        $fields = [
            'attraction_id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'attraction_facility_id' => [
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
        $this->forge->addPrimaryKey('attraction_id');
        $this->forge->addPrimaryKey('attraction_facility_id');
        $this->forge->addForeignKey('attraction_id', 'attraction', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('attraction_facility_id', 'attraction_facility', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attraction_facility_detail');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('attraction_facility_detail');
    }
}
