<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTitleFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'title' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'website'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'title');
	}
}
