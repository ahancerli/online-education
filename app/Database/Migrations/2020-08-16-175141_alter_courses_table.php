<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->modifyColumn('courses', [
            'discount_ratio' => [
                'type' => 'double',
                'null' => true,
                'default' => 0
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
