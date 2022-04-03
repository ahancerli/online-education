<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifySiteSettingsTable extends Migration
{
	public function up()
	{
		$this->forge->modifyColumn('site_settings', [
		    'site_description' => [
		        'type' => 'longtext',
                'null' => true
            ],
            'site_keywords' => [
                'type' => 'longtext',
                'null' => true
            ],
            'site_author' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'site_phone' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'site_email' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'site_gsm' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'site_fax' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'google_analytics' => [
                'type' => 'longtext',
                'null' => true
            ],
            'bulutchat_js' => [
                'type' => 'longtext',
                'null' => true
            ],
            'smtp_host' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'smtp_user' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'smtp_password' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'smtp_port' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true
            ],
            'maintenance_mode' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => true
            ],
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
