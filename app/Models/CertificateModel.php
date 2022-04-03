<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 18.09.2020
 * Time: 17:13
 */

namespace App\Models;


use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table = 'certificates';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'course_id'];
}