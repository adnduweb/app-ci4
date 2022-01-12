<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableModule extends Migration
{
    public function up()
    {
        $fields = [
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
			'handle'       => ['type' => 'VARCHAR', 'constraint' => 255],
			'path'         => ['type' => 'VARCHAR', 'constraint' => 255],
			'is_natif'     => ['type' => 'INT', 'constraint' => 11],
			'is_installed' => ['type' => 'INT', 'constraint' => 11],
			'active'       => ['type' => 'INT', 'constraint' => 11],
			'created_at'   => ['type' => 'DATETIME', 'null' => true],
			'updated_at'   => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('id');
		$this->forge->addKey('name');
		$this->forge->addKey('created_at');
		$this->forge->addKey('updated_at');
		
		$this->forge->createTable('modules');
    }

    public function down()
    {
        $this->forge->dropTable('modules');
    }
}
