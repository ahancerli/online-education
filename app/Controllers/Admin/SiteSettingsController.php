<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 20.08.2020
 * Time: 16:37
 */

namespace App\Controllers\Admin;

use App\Models\SiteSettingsModel;
use CodeIgniter\Controller;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $siteSettingsModel = new SiteSettingsModel();
        $siteSettings = $siteSettingsModel->first();

        return view('admin/site_settings/index', compact('siteSettings'));
    }

    public function update()
    {
        $siteSettingsModel = new SiteSettingsModel();
        $postData = $this->request->getPost();

        if (!$siteSettingsModel->validate($postData))
            return redirect()->back()->withInput()->with('errors', $siteSettingsModel->getValidationMessages());

        if ($siteSettings = $siteSettingsModel->first())
            $siteSettingsModel->update($siteSettings['id'], $postData);
        else
            $siteSettingsModel->insert($postData);

        return redirect()->back()->withInput()->with('message', 'Site ayarları başarıyla güncellendi');
    }
}