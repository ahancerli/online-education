<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLiveVideosTable extends Migration
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
                'constraint' => 255
            ],
            'video_link' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'document_json' => [
                'type' => 'longtext'
            ],
            'course_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'section_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true
            ],
            'created_at' => [
                'type' => 'datetime',
            ],
            'updated_at' => [
                'type' => 'datetime',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('live_videos');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('live_videos');
	}
}
