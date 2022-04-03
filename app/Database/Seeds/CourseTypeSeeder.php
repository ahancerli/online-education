<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 16.08.2020
 * Time: 01:38
 */

namespace App\Database\Seeds;


use App\Helpers\SystemParameter;
use CodeIgniter\Database\Seeder;

class CourseTypeSeeder extends Seeder
{
    public function run()
    {
        $courseTypes = SystemParameter::COURSE_TYPES;
        foreach ($courseTypes as $id => $type)
            $this->db->table('course_types')->insert([
                'id' => $id,
                'name' => $type
            ]);
    }
}