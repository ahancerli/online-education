<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
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
            'title' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'longtext',
                'null' => true
            ],
            'category_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
            ],
            'course_type_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true
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
            'publish_date' => [
                'type' => 'datetime'
            ],
            'price' => [
                'type' => 'double'
            ],
            'discount_ratio' => [
                'type' => 'double'
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('courses');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('courses');
	}
}
