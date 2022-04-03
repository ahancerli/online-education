<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyDeletedAtFieldInLessonsTable extends Migration
{
	public function up()
	{
		$this->forge->modifyColumn('lessons', [
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
