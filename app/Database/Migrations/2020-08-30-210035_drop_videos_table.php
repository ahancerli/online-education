<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropVideosTable extends Migration
{
	public function up()
	{
		$this->forge->dropTable('videos');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
