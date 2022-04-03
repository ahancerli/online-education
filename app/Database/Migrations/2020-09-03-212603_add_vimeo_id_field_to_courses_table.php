<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVimeoIdFieldToCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'vimeo_id' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'course_type_id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('courses', 'vimeo_id');
	}
}
