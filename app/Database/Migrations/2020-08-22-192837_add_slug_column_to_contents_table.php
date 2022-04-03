<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugColumnToContentsTable extends Migration {
    public function up()
    {
        $this->forge->addColumn('contents', [
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255
            ]
        ]);
    }


    public function down()
    {
        $this->forge->dropColumn('contents', 'slug');
    }
}