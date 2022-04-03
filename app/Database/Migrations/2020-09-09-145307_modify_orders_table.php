<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyOrdersTable extends Migration
{
	public function up()
	{
		/*$this->forge->modifyColumn('orders', [
		    'course_id' => [
		        'type' => 'varchar',
                'constraint' => 255
            ]
        ]);*/

		$this->forge->addColumn('orders', [
            'amount' => [
                'type' => 'double',
                'after' => 'user_id'
            ],
            'created_at' => [
                'type' => 'datetime'
            ],
            'updated_at' => [
                'type' => 'datetime'
            ]
        ]);

		$this->forge->dropColumn('orders', 'purchase_date');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
