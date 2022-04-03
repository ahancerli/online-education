<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 23.08.2020
 * Time: 23:06
 */

namespace App\Controllers\Front;


use App\Models\ContentsModel;
use CodeIgniter\Controller;

class ContentController extends Controller
{
    public function index($slug)
    {
        $contentModel = new ContentsModel();
        $content = $contentModel->where('slug', $slug)->where('status', true)->first();

        if (!$content)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $pageTitle = $content ? $content['name'] : '';

        return view('front/content', compact('content', 'pageTitle'));
    }
}