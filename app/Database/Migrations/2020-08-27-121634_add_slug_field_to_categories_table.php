<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugFieldToCategoriesTable extends Migration
{
	public function up()
	{
        $this->forge->addColumn('categories', [
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255,
                'unique' => true,
                'after' => 'sort_order'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('categories', 'slug');
	}
}
