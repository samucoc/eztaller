<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableCategory extends Migration
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
            'categoryGroup_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],

            'categoryName' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'categoryType' => [
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
        $this->forge->addForeignKey('categoryGroup_id', 'categorygroups', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('categories');
   }

    public function down()
    {
        $this->forge->dropTable('categories');
    }  
}
