<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableUser extends Migration
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
            'role_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'userEmail' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'userPassword' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'userPasswordRecoveryToken' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'userPasswordRecoveryTokenExpirationDateTime' => [
                'type' => 'DATETIME',
            ],
            'userFullName' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'userDNI' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'userPhone' => [
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
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users');
   }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
