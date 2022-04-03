<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropLinkColumnFromLessonsTable extends Migration
{
	public function up()
	{
		$this->forge->dropColumn('lessons', 'link');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
