<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWebsiteFieldToUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('users', [
		    'website' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'phone'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'website');
	}
}
