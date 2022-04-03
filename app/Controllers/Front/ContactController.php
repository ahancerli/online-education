<?php

namespace App\Controllers\Front;

use App\Models\SiteSettingsModel;
use CodeIgniter\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $siteSettingModel = new SiteSettingsModel();
        $settings = $siteSettingModel->first();
        $pageTitle = 'İletişim';

        return view('front/contact',compact('settings', 'pageTitle'));
    }

    public function sendMail()
    {
        $rules = [
            'form_name' => 'required',
            'form_email' => 'required',
            'form_subject' => 'required',
            'form_message' => 'required',
            'g-recaptcha-response' => 'required',
        ];

        $messages = [
            'form_name' => [
                'required' => 'Ad Soyad alanı gereklidir'
            ],
            'form_email' => [
                'required' => 'E-posta alanı gereklidir'
            ],
            'form_subject' => [
                'required' => 'Mesaj konusu gereklidir'
            ],
            'form_message' => [
                'required' => 'Mesaj alanı gereklidir'
            ],
        ];

        if (!$this->validate($rules, $messages))
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $secretKey = '6Lfkbs0ZAAAAAPZ_rOjA__rPIMP4HYZiCXkegZd2';
        $token = $this->request->getPost('g-recaptcha-response');

        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
            . $secretKey . '&response=' . $token . '&remoteip=' . $this->request->getIPAddress();

        $result = file_get_contents($url);
        $result = json_decode($result);

        if ($result->success === false)
            return redirect()->back()->withInput()->with('error', 'Kullanıcı doğrulanamadı');

        $email = \Config\Services::email();

        $email->setFrom($email->fromEmail);
        $email->setTo($email->fromEmail);

        $message = 'Ad Soyad: ' . $this->request->getPost('form_name') . PHP_EOL;
        $message .= 'E-posta: ' . $this->request->getPost('form_email') . PHP_EOL;
        $message .= 'Konu: ' . $this->request->getPost('form_subject') . PHP_EOL;
        $message .= 'Mesaj: ' . $this->request->getPost('form_message') . PHP_EOL;

        $email->setSubject('İletişim Formu');
        $email->setMessage($message);

        if (! $email->send())
            return redirect()->back()->withInput()->with('error', 'Mesajınız gönderilemedi!');

        return redirect()->back()->with('message', 'Mesajınız başarıyla gönderildi');
    }
}