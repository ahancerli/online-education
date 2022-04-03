<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 29.08.2020
 * Time: 23:04
 */

namespace App\Models;


use CodeIgniter\Model;

class LessonModel extends Model
{
    protected $table = 'lessons';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name', 'course_id', 'section_id', 'vimeo_id', 'document_name', 'status'
    ];

    protected $validationRules = [
        'name' => 'required',
        'course_id' => 'required|numeric'
    ];
}