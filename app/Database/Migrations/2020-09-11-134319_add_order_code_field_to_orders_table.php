<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderCodeFieldToOrdersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('orders', [
		    'order_code' => [
		        'type' => 'varchar',
                'constraint' => 255,
                'after' => 'id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('orders', 'order_code');
	}
}
