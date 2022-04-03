<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCategoriesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('categories', [
		    'sort_order' => [
		        'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'default' => 0,
                'after' => 'status'
            ],
            'updated_at' => [
                'type' => 'datetime',
                'after' => 'created_at'
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
                'after' => 'updated_at'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
