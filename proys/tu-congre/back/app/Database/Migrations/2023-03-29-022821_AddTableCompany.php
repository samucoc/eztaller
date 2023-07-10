<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCompany extends Migration
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
            'state_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'city_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'companyName' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyDNI' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyAddress' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyManagerName' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyManagerPhone' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyManagerEmail' => [
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
        $this->forge->addForeignKey('state_id', 'states', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('city_id', 'cities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('companies');
   }

    public function down()
    {
        $this->forge->dropTable('companies');
    }
}
