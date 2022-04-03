<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 18.08.2020
 * Time: 22:48
 */

namespace App\Models;

use CodeIgniter\Model;

class SectionModel extends Model
{
    protected $table = 'sections';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name', 'course_id'
    ];

    protected $validationRules = [
        'name' => 'required',
        'course_id' => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Bölüm adı gereklidir',
        ],
        'course_id' => [
            'required' => 'Lütfen bir kurs seçin'
        ]
    ];
}