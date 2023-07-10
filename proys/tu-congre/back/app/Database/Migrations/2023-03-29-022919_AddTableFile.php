<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableFile extends Migration
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
            'fileName' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'fileExtension' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'fileURL' => [
                'type' => 'VARCHAR',
                'constraint' => '512',
            ],
            'fileSource' => [
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
        $this->forge->createTable('files');
   }

    public function down()
    {
        $this->forge->dropTable('files');
    }
}
