<?php 

namespace Adnduweb\Ci4Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableSessions extends Migration
{

	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'       => 'VARCHAR',
				'constraint' => 128,
				'null'       => false
			],
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => false
			],
			'user_id' => [
				'type'       => 'INT',
				'constraint' => 11,
				'null'       => true
			],
			'user_agent' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
			],
			'timestamp'  => [
				'type'       => 'INT',
				'constraint' => 10,
				'unsigned'   => true,
				'null'       => false,
				'default'    => 0
			],
			'data'       => [
				'type'       => 'TEXT',
				'null'       => false,
				'default'    => ''
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('timestamp');
		$this->forge->createTable('sessions', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sessions', true);
	}
}
