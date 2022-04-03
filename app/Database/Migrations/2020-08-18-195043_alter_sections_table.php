<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterSectionsTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('sections', [
		    'created_at' => [
		        'type' => 'datetime',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('sections', ['created_at', 'updated_at', 'deleted_at']);
	}
}
