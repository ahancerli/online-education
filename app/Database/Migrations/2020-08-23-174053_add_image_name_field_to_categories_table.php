<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageNameFieldToCategoriesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('categories', [
		    'image_name' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'sort_order'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('categories', 'image_name');
	}
}
