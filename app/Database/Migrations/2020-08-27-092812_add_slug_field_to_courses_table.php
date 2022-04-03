<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugFieldToCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'slug' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'unique' => true,
                'after' => 'status'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('courses', 'slug');
	}
}
