<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommentIdColumnToRatingsTable extends Migration
{
	public function up()
	{
		$this->forge->addColumn('ratings', [
		    'comment_id' => [
		        'type' => 'int',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
                'after' => 'course_id'
            ]
        ]);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('ratings', 'comment_id');
	}
}
