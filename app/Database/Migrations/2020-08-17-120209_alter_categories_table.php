<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyCategoriesColumn extends Migration
{
	public function up()
	{
		$this->forge->modifyColumn('categories', [
		    'parent_id' => [
		        'type' => 'int',
                'contraint' => 11,
                'null' => true,
                'default' => 0
            ],
            'status' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => true,
                'default' => 0
            ],
            'sort_order' => [
                'type' => 'int',
                'constraint' => 11,
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
