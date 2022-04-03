<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContentsTable extends Migration
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
            'content' => [
                'type' => 'longtext',
            ],
            'status' => [
                'type' => 'tinyint',
                'constraint' => 1
            ],
            'created_at' => [
                'type' => 'datetime',
            ],
            'updated_at' => [
                'type' => 'datetime',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('contents');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('contents');
	}
}
