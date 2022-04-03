<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtFieldToCommentsTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('comments', [
		    'updated_at' => [
		        'type' => 'datetime'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('comments', 'updated_at');
	}
}
