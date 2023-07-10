<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableTicket extends Migration
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
            'companyUser_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'application_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],


            'ticketStatus' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'ticketTitle' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'ticketDescription' => [
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
        $this->forge->addForeignKey('companyUser_id', 'companyusers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('company_id', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('application_id', 'applications', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');


        $this->forge->createTable('tickets');
   }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }   
}
