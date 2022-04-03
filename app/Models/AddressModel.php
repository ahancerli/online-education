<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 8.09.2020
 * Time: 19:28
 */

namespace App\Models;


use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $allowedFields = [
        'name', 'surname', 'phone', 'identity_number', 'country', 'city', 'county',
        'postal_code', 'company_name', 'tax_office', 'address', 'user_id'
    ];
}