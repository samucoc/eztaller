<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableTicketResponseFile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ticketResponse_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'file_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ticketResponse_id', 'ticketresponses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('file_id', 'files', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('ticketresponsefiles');
   }

    public function down()
    {
        $this->forge->dropTable('ticketresponsefiles');
    }  
}
