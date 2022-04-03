<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'parent_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'status' => [
                'type' => 'tinyint',
                'constraint' => 1
            ],
            'created_at' => [
                'type' => 'timestamp'
            ]
        ]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('categories');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('categories');
	}
}
