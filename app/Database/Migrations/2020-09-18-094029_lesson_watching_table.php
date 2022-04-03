<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LessonWatchingTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'lesson_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'course_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'timestamp'
            ],
        ]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('lesson_watching');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('lesson_watching');
	}
}
