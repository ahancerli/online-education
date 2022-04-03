<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 8.09.2020
 * Time: 18:53
 */

namespace App\Models;


use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $useTimestamps = true;
    protected $allowedFields = ['course_id', 'user_id'];
}