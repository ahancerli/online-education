<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'image_name' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'description'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
