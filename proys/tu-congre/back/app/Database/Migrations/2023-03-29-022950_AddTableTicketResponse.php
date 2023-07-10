<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableTicketResponse extends Migration
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
            'ticket_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'companyUser_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'ticketResponseSource' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'ticketResponseData' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
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
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('companyUser_id', 'companyusers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('ticketresponses');
   }

    public function down()
    {
        $this->forge->dropTable('ticketresponses');
    }  
}
