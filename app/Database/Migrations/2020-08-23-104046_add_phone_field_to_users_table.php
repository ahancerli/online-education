<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhoneFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'phone' => [
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
		$this->forge->dropColumn('users', 'phone');
	}
}
