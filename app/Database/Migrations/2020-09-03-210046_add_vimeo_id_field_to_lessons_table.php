<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVimeoIdFieldToLessonsTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('lessons', [
		    'vimeo_id' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
                'after' => 'section_id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('lessons', 'vimeo_id');
	}
}
