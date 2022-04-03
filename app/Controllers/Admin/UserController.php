<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 11.09.2020
 * Time: 20:13
 */

namespace App\Controllers\Admin;


use CodeIgniter\Controller;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class UserController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = config('Auth');
    }

    public function index()
    {
        $users = model('UserModel')
            ->where('role', 'admin')
            ->where('id !=', user_id())
            ->findAll();

        $users = array_map(function ($user) {
            $createdAt = $user->created_at->toDateString();
            $updatedAt = $user->updated_at->toDateString();

            $user = $user->toArray();
            $user['created_at'] = $createdAt;
            $user['updated_at'] = $updatedAt;

            return $user;
        }, $users);

        return view('admin/user/index', compact('users'));
    }

    public function create()
    {
        return view('admin/user/create', ['mode' => 'create']);
    }

    public function attemptCreate()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());

        $users = model('UserModel');

        $allowedPostFields = array_merge(['password', 'role', 'active'], $this->config->validFields, $this->config->personalFields);
        $postData = $this->request->getPost($allowedPostFields);
        $postData['active'] = isset($postData['active']) ? 1 : 0;
        $postData['role'] = 'admin';
        $user = new User($postData);

        if (!$users->save($user))
            return redirect()->back()->withInput()->with('errors', $users->errors());

        return redirect()->back()->with('message', 'Kullanıcı başarıyla oluşturuldu');
    }

    public function edit($id)
    {
        $user = model('UserModel')->find($id);
        if (!$user)
            return redirect()->to('/admin/user');

        if ($user->id == user_id())
            return redirect()->to('/admin/user');

        $mode = 'edit';

        return view('admin/user/create', compact('user', 'mode'));
    }

    public function update()
    {
        $rules = [
            'user_id' => 'required',
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'password_confirm' => 'matches[password]',
        ];

        if (!$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());

        $userModel = new UserModel();

        if ($userModel
            ->where('email', $this->request->getPost('email'))
            ->where('id !=', $this->request->getPost('user_id'))
            ->first()) {
            return redirect()->back()->withInput()->with('errors', [
                'Bu e-posta adresi sisteme zaten kayıtlı'
            ]);
        }

        if ($userModel
            ->where('username', $this->request->getPost('username'))
            ->where('id !=', $this->request->getPost('user_id'))
            ->first()) {
            return redirect()->back()->withInput()->with('errors', [
                'Bu kullanıcı adı başka bir kullanıcı tarafından kullanılıyor'
            ]);
        }

        $userId = $this->request->getPost('user_id');
        $user = $userModel->find($userId);

        if (!$user)
            return redirect()->to('/admin/user');

        if ($user->id == user_id())
            return redirect()->to('/admin/user');

        $postData = $this->request->getPost();

        if ($this->request->getPost('password') == '') {
            unset($postData['password']);
            unset($postData['password_confirm']);
        }

        if (!$userModel->update($userId, $postData))
            return redirect()->back()->with('error', 'Kullanıcı güncellenemedi');

        return redirect()->back()->with('message', 'Kullanıcı başarıyla güncellendi');
    }
}