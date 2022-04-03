<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtColumnToCourses extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'deleted_at' => [
		        'type' => 'datetime',
                'null' => true
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
