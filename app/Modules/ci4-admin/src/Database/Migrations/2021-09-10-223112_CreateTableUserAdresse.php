<?php namespace Adnduweb\Ci4Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUserAdresse extends Migration
{
    public function up()
    {
        /*
         * User Adresse
         */
        $this->forge->addField([
            'id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'country_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'adresse1'     => ['type' => 'varchar', 'constraint' => 255],
            'adresse2'     => ['type' => 'varchar', 'constraint' => 255],
            'code_postal'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ville'        => ['type' => 'varchar', 'constraint' => 255],
            'phone'        => ['type' => 'VARCHAR',  'constraint' => 255],
            'phone_mobile' => ['type' => 'VARCHAR',  'constraint' => 255],
            'created_at'   => ['type' => 'datetime', 'null' => true],
            'updated_at'   => ['type' => 'datetime', 'null' => true],
            'deleted_at'   => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('country_id', 'countries', 'id', false, 'CASCADE');
        $this->forge->createTable('users_adresses', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
		// drop constraints first to prevent errors
        if ($this->db->DBDriver != 'SQLite3')
        {
            $this->forge->dropForeignKey('users_adresses', 'users_adresses_country_id_foreign');
        }

        $this->forge->dropTable('users_adresses', true);
    }
}
