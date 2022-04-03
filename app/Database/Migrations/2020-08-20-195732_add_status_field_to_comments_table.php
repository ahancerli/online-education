<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusFieldToCommentsTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('comments', [
		    'status' => [
		        'type' => 'tinyint',
                'constraint' => 1,
                'null' => true,
                'default' => 0
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('comments', 'status');
	}
}
