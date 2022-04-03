<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfileImageFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
            'profile_image' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'email'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'profile_image');
	}
}
