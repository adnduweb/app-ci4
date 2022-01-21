<?php namespace Adnduweb\Ci4Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAuth extends Migration
{
    public function up()
    {
        /*
         * Users
         */
        $this->forge->addField([
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
             'uuid'                      => ['type' => 'BINARY', 'constraint' => 16, 'unique' => true],
            //'uuid'                      => ['type' => 'VARCHAR', 'constraint' => 255],
            'company_id'           => ['type' => 'INT', 'constraint' => 16, 'default' => 1],
            'lang'                 => ['type' => 'VARCHAR',  'constraint' => 48, 'default' => 75],
            'lastname'             => ['type' => 'VARCHAR',  'constraint' => 255],
            'firstname'            => ['type' => 'VARCHAR',  'constraint' => 255],
            'fonction'             => ['type' => 'VARCHAR',  'constraint' => 255],
            'email'                => ['type' => 'varchar', 'constraint' => 255],
            'username'             => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'password_hash'        => ['type' => 'varchar', 'constraint' => 255],
            'reset_hash'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_at'             => ['type' => 'datetime', 'null' => true],
            'reset_expires'        => ['type' => 'datetime', 'null' => true],
            'activate_hash'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'two_factor'           => ['type' => 'varchar', 'constraint' => 48],
            'two_factor_confirmed' => ['type' => 'int', 'constraint' => 11, 'default' => 0],
            'status'               => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'               => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'force_pass_reset'     => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'is_principal'         => ['type' => 'INT', 'constraint' => 11,  'default' => 0],
            'last_login_at'        => ['type' => 'datetime', 'null' => true],
            'last_login_ip'        => ['type' => 'VARCHAR',  'constraint' => 255],
            'created_at'           => ['type' => 'datetime', 'null' => true],
            'updated_at'           => ['type' => 'datetime', 'null' => true],
            'deleted_at'           => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');

        $this->forge->createTable('users', true);

        /*
         * Auth Login Attempts
         */
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'agent'      => ['type' => 'VARCHAR',  'constraint' => 255],
            'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],             // Only for successful logins
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('user_id');
        // NOTE: Do NOT delete the user_id or email when the user is deleted for security audits
        $this->forge->createTable('auth_logins', true);

        /*
         * Auth Tokens
         * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
         */
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'selector'        => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'expires'         => ['type' => 'datetime'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('selector');
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        /*
         * Password Reset Table
         */
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts');

        /*
         * Activation Attempts Table
         */
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_activation_attempts');

        /*
         * Groups Table
         */
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'              => ['type' => 'varchar', 'constraint' => 255],
            'description'       => ['type' => 'varchar', 'constraint' => 255],
            'login_destination' => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_hide'           => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        /*
         * Permissions Table
         */
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
            'is_natif'    => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_permissions', true);

        /*
         * Groups/Permissions Table
         */
        $fields = [
            'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['group_id', 'permission_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_groups_permissions', true);

        /*
         * Users/Groups Table
         */
        $fields = [
            'group_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['group_id', 'user_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        /*
         * Users/Permissions Table
         */
        $fields = [
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_users_permissions');


         /*
         * Users 2FA
         */
        $fields = [
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'                   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'type'                      => ['type' => 'varchar', 'constraint' => 48],
            'two_factor_secret'         => ['type' => 'text', 'null' => true],
            'two_factor_recovery_codes' => ['type' => 'text', 'null' => true],
            'opt_mobile'                => ['type' => 'varchar', 'constraint' => 48],
            'opt_email'                 => ['type' => 'varchar', 'constraint' => 48],
            'code_temp'                 => ['type' => 'varchar', 'constraint' => 48],
            'is_verified'               => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'two_factor_expires_at'     => ['type' => 'datetime', 'null' => true],
            'created_at'                => ['type' => 'datetime', 'null' => true],
            'updated_at'                => ['type' => 'datetime', 'null' => true],
            'deleted_at'                => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['user_id', 'type']);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('auth_users_two_factors');
    }

    //--------------------------------------------------------------------

    public function down()
    {
		// drop constraints first to prevent errors
        if ($this->db->DBDriver != 'SQLite3')
        {
            $this->forge->dropForeignKey('auth_tokens', 'auth_tokens_user_id_foreign');
            $this->forge->dropForeignKey('auth_groups_permissions', 'auth_groups_permissions_group_id_foreign');
            $this->forge->dropForeignKey('auth_groups_permissions', 'auth_groups_permissions_permission_id_foreign');
            $this->forge->dropForeignKey('auth_groups_users', 'auth_groups_users_group_id_foreign');
            $this->forge->dropForeignKey('auth_groups_users', 'auth_groups_users_user_id_foreign');
            $this->forge->dropForeignKey('auth_users_permissions', 'auth_users_permissions_user_id_foreign');
            $this->forge->dropForeignKey('auth_users_permissions', 'auth_users_permissions_permission_id_foreign');
            $this->forge->dropForeignKey('auth_users_two_factors', 'auth_users_two_factors_user_id_foreign');
        }

		$this->forge->dropTable('users', true);
		$this->forge->dropTable('auth_logins', true);
		$this->forge->dropTable('auth_tokens', true);
		$this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_activation_attempts', true);
		$this->forge->dropTable('auth_groups', true);
		$this->forge->dropTable('auth_permissions', true);
		$this->forge->dropTable('auth_groups_permissions', true);
		$this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_users_permissions', true);
        $this->forge->dropTable('auth_users_two_factors', true);
    }
}
