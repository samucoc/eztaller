<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableApplication extends Migration
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
            'company_id' => [
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
            'contest_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],

            'applicationTitle' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationDescription' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'userPasswordRecoveryToken' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationImplementationDate' => [
                'type' => 'INT',
                'constraint' => 10,
            ],
            'applicationStatusDraft' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusAfterDraft' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusPreselection' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusFinalist' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusFinal' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusEditedByCompany' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusEditedByCompanyDateTime' => [
                'type' => 'DATETIME',
            ],
            'applicationStatusEditedByAdmin' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'applicationStatusEditedByAdminDateTime' => [
                'type' => 'DATETIME',
            ],
            'applicationStatusPublished' => [
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
        $this->forge->addForeignKey('company_id', 'companies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('companyUser_id', 'companyusers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('contest_id', 'contests', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('applications');
   }

    public function down()
    {
        $this->forge->dropTable('applications');
    }
}
