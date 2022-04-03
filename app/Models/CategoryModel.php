<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'parent_id',
        'status',
        'sort_order',
        'image_name',
        'slug'
    ];

    protected $validationRules = [
        'name' => 'required',
        'parent_id' => 'numeric',
        'sort_order' => 'numeric'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Kategori adı gereklidir'
        ],
        'parent_id' => [
            'numeric' => 'Lütfen geçerli bir ana kategori seçin'
        ],
        'sort_order' => [
            'numeric' => 'Lütfen geçerli bir sıra numarası seçin'
        ],
    ];
}