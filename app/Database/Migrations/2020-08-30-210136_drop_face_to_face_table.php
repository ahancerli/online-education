<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropFaceToFaceTable extends Migration
{
	public function up()
	{
		$this->forge->dropTable('face_to_face');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
