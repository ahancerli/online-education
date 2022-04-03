<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'surname' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'phone' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'identity_number' => [
                'type' => 'varchar',
                'constraint' => 11
            ],
            'country' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'city' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'county' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'postal_code' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'company_name' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'tax_office' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'address' => [
                'type' => 'longtext'
            ],
            'user_id' => [
                'type' => 'int',
                'constraint' => 11
            ]
        ]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('addresses');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
