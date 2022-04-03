<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLessonsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'course_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'section_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'link' => [
                'type' => 'longtext',
                'null' => true
            ],
            'document_name' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'status' => [
                'type' => 'tinyint',
                'constraint' => 1
            ],
            'created_at' => [
                'type' => 'datetime'
            ],
            'updated_at' => [
                'type' => 'datetime'
            ],
            'deleted_at' => [
                'type' => 'datetime'
            ],
        ]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('lessons');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('lessons');
	}
}
