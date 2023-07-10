<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableTag extends Migration
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

            'category_id' => [
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
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('tags');
   }

    public function down()
    {
        $this->forge->dropTable('tags');
    } 
}
