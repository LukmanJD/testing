<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttractionTicketPrice extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
            ],
            'attraction_id' => [
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
        $this->forge->createTable('attraction_ticket_price');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('attraction_ticket_price');
    }
}
