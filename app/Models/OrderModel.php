<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 9.09.2020
 * Time: 17:51
 */

namespace App\Models;


use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $useTimestamps = true;

    protected $allowedFields = ['course_id', 'user_id', 'amount', 'order_code', 'order_note'];
}