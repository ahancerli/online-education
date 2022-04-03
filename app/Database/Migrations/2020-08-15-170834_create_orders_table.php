<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
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
            'purchase_date' => [
                'type' => 'datetime'
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropTable('orders');
	}
}
