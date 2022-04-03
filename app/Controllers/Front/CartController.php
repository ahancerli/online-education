<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 26.08.2020
 * Time: 21:40
 */

namespace App\Controllers\Front;


use CodeIgniter\Controller;

class CartController extends Controller
{
    public function __construct()
    {
        helper('cookie');
    }

    public function index()
    {
        $cart = get_cookie('cart') ? json_decode(get_cookie('cart'), true) : [];
        $courses = [];

        if ($this->request->getGet('remove_course')) {
            $courseId = $this->request->getGet('remove_course');

            if (is_numeric($courseId)) {
                $index = array_search($courseId, $cart);
                 if ($index !== false) {
                     unset($cart[$index]);
                     set_cookie('cart', json_encode($cart), time() + 86400);
                 }
            }
        }

        if (count($cart) > 0)
            $courses = model('CourseModel')
                ->where('status', 1)
                ->whereIn('id', $cart)
                ->select('id, title, image_name, slug, price, discount_ratio')
                ->findAll();

        $pageTitle = 'Sepet';

        return view('front/cart', compact('courses', 'pageTitle'));
    }

    public function addToCart()
    {
        $rules = ['course_id' => 'required'];

        if (!$this->validate($rules))
            return $this->response->setJSON([
                'status' => 'fail',
                'message' => 'Eksik parametre girişi'
            ])->setStatusCode(422);

        $courseId = $this->request->getPost('course_id');

        $course = model('CourseModel')->where('status', 1)->find($courseId);

        if (!$course)
            return $this->response->setJSON([
                'status' => 'fail',
                'message' => 'Not found'
            ])->setStatusCode(404);

        $cart = get_cookie('cart') ? json_decode(get_cookie('cart')) : [];

        if (!in_array($courseId, $cart))
            array_push($cart, intval($courseId));

        set_cookie('cart', json_encode($cart), time() + 86400);

        return $this->response->setJSON([
            'status' => 'success'
        ])->setStatusCode(200);
    }
}