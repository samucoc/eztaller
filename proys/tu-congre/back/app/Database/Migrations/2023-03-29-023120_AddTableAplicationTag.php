<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableApplicationTag extends Migration
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

            'application_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],
            'tag_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,

            ],

            'tagName' => [
                'type' => 'VARCHAR',
                'constraint' => 512,
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
        $this->forge->addForeignKey('application_id', 'applications', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('applicationtags');
   }

    public function down()
    {
        $this->forge->dropTable('applicationtags');
    } 
}
