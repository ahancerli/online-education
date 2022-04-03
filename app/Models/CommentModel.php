<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 20.08.2020
 * Time: 23:00
 */

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id', 'course_id', 'comment', 'status'
    ];

    /*protected $validationRules = [
        'user_id' => 'required|numeric',
        'course_id' => 'required|numeric',
        'comment' => 'required',
        'status' => 'numeric'
    ];*/
}