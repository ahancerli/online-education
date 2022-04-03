<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteSettingsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
		    'id' => [
		        'type' => 'int',
                'constraint' => 1,
                'unsigned' => true,
                'auto_increment'
            ],
            'site_title' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_description' => [
                'type' => 'longtext',
            ],
            'site_keywords' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_author' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_phone' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_email' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_gsm' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'site_fax' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'google_analytics' => [
                'type' => 'longtext'
            ],
            'bulutchat_js' => [
                'type' => 'longtext'
            ],
            'smtp_host' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'smtp_user' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'smtp_password' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'smtp_port' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'maintenance_mode' => [
                'type' => 'tinyint',
                'constraint' => 1
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('site_settings');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('site_settings');
	}
}
