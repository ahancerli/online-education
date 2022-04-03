<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 29.08.2020
 * Time: 16:59
 */

namespace App\Controllers\Front;


use App\Models\CourseModel;
use App\Models\OrderModel;
use CodeIgniter\Controller;
use Myth\Auth\Models\UserModel;


class AccountController extends Controller
{
    public function index()
    {

        return view('front/account/account');
    }

    public function courses()
    {
        $courseModel = new CourseModel();
        $courses = $courseModel
            ->join('enrollments', 'enrollments.course_id = courses.id')
            ->join('users', 'users.id = courses.user_id')
            ->join('comments', 'comments.course_id = courses.id', 'LEFT')
            ->join('ratings', 'ratings.course_id = courses.id', 'LEFT')
            ->groupBy('courses.id')
            ->select('courses.*, users.name AS instructor_name')
            ->selectCount('comments.id', 'comment_count')
            ->selectCount('enrollments.id', 'user_count')
            ->selectAvg('ratings.point', 'avg_point')
            ->findAll();

        return view('front/account/mycourses',compact('courses'));
    }

    public function orders()
    {
        $orderModel = new OrderModel();

        $orders = $orderModel->where('user_id',user_id())->findAll();

        foreach ($orders as $index => $order) {
            $courseId = json_decode($order['course_id']);
            $orders[$index]['courses'] = model('CourseModel')->whereIn('id', $courseId)->findAll();
        }

        return view('front/account/myorders', compact('orders'));
    }

    public function profile()
    {
        return view('front/account/profile');
    }

    public function attemptUpdateProfile()
    {
        $rules = [
            'name' => 'required|alpha',
            'phone' => 'regex_match[/^[0-9\-\(\)\/\+\s]*$/]'
        ];

        if ($this->validate($rules))
            return redirect()
                ->to('/account/profile')
                ->withInput()
                ->with('errors', $this->validator->getErrors());

        $postData = $this->request->getPost();


        $userModel = new UserModel();
        $userModel->update(user_id(), $postData);

        return redirect()
            ->to('/account/profile')
            ->with('message', 'Profil başarıyla güncellendi');
    }

    public function changePassword()
    {
        return view('front/account/change_password');
    }

    public function attemptChangePassword()
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|strong_password',
            'new_pass_confirm' => 'required|matches[new_password]',
        ];
        $messages = [
            'new_pass_confirm' => [
                'matches' => 'Girdiğiniz şifreler eşleşmiyor'
            ]
        ];

        if (!$this->validate($rules, $messages))
            return redirect()
                ->to('/account/change_password')
                ->with('errors', $this->validator->getErrors());

        $oldPassword = base64_encode(
            hash('sha384', $this->request->getPost('old_password'), true)
        );

        if (!password_verify($oldPassword, user()->password_hash))
            return redirect()
                ->to('/account/change_password')
                ->with('error', 'Eski şifreniz doğru değil');

        $userModel = new UserModel();

        $user = $userModel->find(user_id());
        $user->password = $this->request->getPost('new_password');

        $userModel->save($user);

        return redirect()
            ->to('/account/change_password')
            ->with('message', 'Şifreniz başarıyla değiştirildi');
    }

    public function certificate()
    {
        $certificates = model('CertificateModel')
            ->select('certificates.*, courses.title AS course_name')
            ->join('courses', 'courses.id = certificates.course_id')
            ->where('certificates.user_id', user_id())
            ->findAll();

        return view('front/account/certificate', compact('certificates'));
    }

}