<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 22.08.2020
 * Time: 21:36
 */

namespace App\Models;


use CodeIgniter\Model;

class ContentsModel extends Model
{
    protected $table = 'contents';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'name', 'content', 'status', 'slug'
    ];

    protected $validationRules = [
        'name' => 'required',
        'status' => 'numeric',
        'slug' => 'required'
    ];
}