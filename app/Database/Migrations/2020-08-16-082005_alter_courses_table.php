<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'user_id' => [
		        'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
