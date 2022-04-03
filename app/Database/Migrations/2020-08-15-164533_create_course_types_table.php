<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseTypesTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255
            ]
        ]);

		$this->forge->createTable('course_types');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('course_types');
	}
}
