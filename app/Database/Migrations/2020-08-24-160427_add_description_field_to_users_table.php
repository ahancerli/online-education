<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescriptionFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'description' => [
		        'type' => 'longtext',
                'constraint' => 0,
                'null' => true,
                'after' => 'role'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'description');
	}
}
