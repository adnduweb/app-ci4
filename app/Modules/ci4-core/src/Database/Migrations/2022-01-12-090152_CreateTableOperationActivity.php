<?php namespace Adnduweb\Ci4Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableOperationActivity extends Migration
{
	public function up()
	{
		// audit logs
		$fields = [
			'class'        => ['type' => 'VARCHAR', 'constraint' => 255],
			'operation_id' => ['type' => 'INT', 'unsigned' => true],
			'is_editing'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
			'editing_by'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
			'user_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
			'created_at'   => ['type' => 'DATETIME', 'null' => true],
			'updated_at'   => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey(['class', 'operation_id', 'user_id']);
		$this->forge->addKey('created_at');

		$this->forge->createTable('operation_activity');
	}

	public function down()
	{
		$this->forge->dropTable('operation_activity');
	}
}
