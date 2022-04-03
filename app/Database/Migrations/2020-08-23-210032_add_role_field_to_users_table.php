<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'role' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'default' => 'customer',
                'after' => 'username'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'role');
	}
}
