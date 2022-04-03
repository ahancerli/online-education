<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'title',
        'description',
        'image_name',
        'document_name',
        'course_type_id',
        'vimeo_id',
        'status',
        'publish_date',
        'price',
        'discount_ratio',
        'user_id',
        'slug'
    ];

    protected $validationRules = [
        'title' => 'required',
        'category_id' => 'required',
        'course_type_id' => 'required|numeric',
        'status' => 'required|numeric',
        'publish_date' => 'required|valid_date',
        'price' => 'required|numeric',
    ];

}