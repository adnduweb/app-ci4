<?php namespace Adnduweb\Ci4Core\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_settings extends Migration
{
	public function up()
	{
		$this->forge->addField('id');
        $this->forge->addField([
            'class' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'key' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'value' => [
                'type' => 'text',
                'null' => true,
            ],
            'type' => [
                'type'       => 'varchar',
                'constraint' => 31,
                'default'    => 'string',
			],
			'context' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'type',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => false,
            ],
        ]);
        $this->forge->createTable(config('Settings')->database['table'], true);
	}

	public function down()
	{
		$this->forge->dropTable(config('Settings')->database['table']);
	}
}
