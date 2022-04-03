<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideosTable extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id' => [
                'type' => 'mediumint',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'course_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'section_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'video_link' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'document_json' => [
                'type' => 'longtext'
            ],
            'status' => [
                'type' => 'tinyint',
                'constraint' => 1,
            ],
            'created_at' => [
                'type' => 'datetime',
            ],
            'updated_at' => [
                'type' => 'datetime',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('videos');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('videos');
	}
}
