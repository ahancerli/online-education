<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 20.08.2020
 * Time: 16:25
 */

namespace App\Models;

use CodeIgniter\Model;

class SiteSettingsModel extends Model
{
    protected $table = 'site_settings';
    protected $allowedFields = [
        'site_title', 'site_description', 'site_keywords', 'site_author', 'site_phone',
        'site_email', 'site_gsm', 'site_fax', 'google_analytics', 'bulutchat_js',
        'smtp_host', 'smtp_user', 'smtp_password', 'smtp_port', 'maintenance_mode',
    ];

    protected $validationRules = [
        'site_title' => 'required'
    ];
}