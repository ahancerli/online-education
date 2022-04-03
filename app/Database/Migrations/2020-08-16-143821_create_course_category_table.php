<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseCategoryTable extends Migration
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
            'course_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'category_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ]
        ]);

	    $this->forge->addKey('id', true);
		$this->forge->createTable('course_category');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
