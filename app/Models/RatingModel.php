<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 16.09.2020
 * Time: 16:12
 */

namespace App\Models;


use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table = 'ratings';
    protected $allowedFields = ['course_id', 'comment_id', 'user_id', 'point'];
}