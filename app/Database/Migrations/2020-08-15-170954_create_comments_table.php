<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
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
                'constraint' => 11
            ],
            'user_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'comment' => [
                'type' => 'longtext'
            ],
            'created_at' => [
                'type' => 'datetime'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('comments');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('comments');
	}
}
