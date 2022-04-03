<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCategoriesTable extends Migration
{
	public function up()
	{
		$this->forge->modifyColumn('categories', [
		    'created_at' => [
		        'type' => 'datetime'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{

	}
}
