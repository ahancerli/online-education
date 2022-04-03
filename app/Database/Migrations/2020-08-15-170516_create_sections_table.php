<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSectionsTable extends Migration
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
            'course_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('sections');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('sections');
	}
}
