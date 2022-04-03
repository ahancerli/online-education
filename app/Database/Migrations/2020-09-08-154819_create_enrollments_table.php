<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollmentsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
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
            'created_at' => [
                'type' => 'datetime'
            ],
            'updated_at' => [
                'type' => 'datetime'
            ],
        ]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('enrollments');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('enrollments');
	}
}
