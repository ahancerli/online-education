<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'name' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'after' => 'id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
