<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 22.08.2020
 * Time: 22:47
 */

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Myth\Auth\Models\UserModel;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin/profile/index');
    }

    public function updateProfile()
    {
        $rules = [
            'name' => 'required|alpha',
            'profile_image' => 'max_size[profile_image,1024]',
            'phone' => 'regex_match[/^[0-9\-\(\)\/\+\s]*$/]',
            'website' => 'valid_url',
            'title' => 'alpha'
        ];

        if ($this->validate($rules))
            return redirect()
                ->to('/admin/profile')
                ->withInput()
                ->with('errors', $this->validator->getErrors());

        $postData = $this->request->getPost();
        if ($this->request->getFile('profile_image')->getError() != 4) {
            $profileImage = $this->request->getFile('profile_image');

            if (!$profileImage->isValid())
                return redirect()->back()->withInput()->with('error', $profileImage->getErrorString());

            $newName = $profileImage->getRandomName();
            if (!$profileImage->move(ROOTPATH . 'public/assets/uploads/user/', $newName))
                return redirect()->back()->withInput()->with('error', 'Profil fotoğrafı yüklenemedi');

            if (user()->profile_image)
                @unlink(ROOTPATH . 'public/assets/uploads/user/' . user()->profile_image);

            $postData['profile_image'] = $newName;
        }

        $userModel = new UserModel();
        $userModel->update(user_id(), $postData);

        return redirect()
            ->to('/admin/profile')
            ->with('message', 'Profil başarıyla güncellendi');
    }

    public function changePassword()
    {
        return view('admin/profile/change_password');
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
                ->to('/admin/profile/change_password')
                ->with('errors', $this->validator->getErrors());

        $oldPassword = base64_encode(
            hash('sha384', $this->request->getPost('old_password'), true)
        );

        if (!password_verify($oldPassword, user()->password_hash))
            return redirect()
                ->to('/admin/profile/change_password')
                ->with('error', 'Eski şifreniz doğru değil');

        $userModel = new UserModel();

        $user = $userModel->find(user_id());
        $user->password = $this->request->getPost('new_password');

        $userModel->save($user);

        return redirect()
            ->to('/admin/profile/change_password')
            ->with('message', 'Şifreniz başarıyla değiştirildi');
    }
}