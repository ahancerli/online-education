<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocumentNameFieldToCoursesTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('courses', [
		    'document_name' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'image_name'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('courses', 'document_name');
	}
}
