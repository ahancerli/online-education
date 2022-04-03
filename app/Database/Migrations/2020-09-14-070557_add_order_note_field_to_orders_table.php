<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderNoteFieldToOrdersTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('orders', [
		    'order_note' => [
		        'type' => 'text',
                'null' => true,
                'after' => 'amount'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('orders', 'order_note');
	}
}
