<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRatingsTable extends Migration
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
            'point' => [
                'type' => 'int',
                'constraint' => 11
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ratings');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('ratings');
	}
}
