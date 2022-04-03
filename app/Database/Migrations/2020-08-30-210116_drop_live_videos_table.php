<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropLiveVideosTable extends Migration
{
	public function up()
	{
		$this->forge->dropTable('live_videos');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
