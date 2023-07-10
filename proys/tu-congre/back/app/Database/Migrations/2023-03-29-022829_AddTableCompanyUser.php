<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCompanyUser extends Migration
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
            'businessRole_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'company_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'companyUserEmail' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyUserPassword' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyUserPasswordRecoveryToken' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyUserPasswordRecoveryTokenExpirationDateTime' => [
                'type' => 'DATETIME',
            ],
            'companyUserFullName' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyUserDNI' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'companyUserPhone' => [
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
        $this->forge->addForeignKey('businessRole_id', 'businessroles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('company_id', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('companyusers');
   }

    public function down()
    {
        $this->forge->dropTable('companyusers');
    }
}
