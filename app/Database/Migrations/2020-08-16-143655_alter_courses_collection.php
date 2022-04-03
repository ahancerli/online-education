<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesCollection extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('courses', 'category_id');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
