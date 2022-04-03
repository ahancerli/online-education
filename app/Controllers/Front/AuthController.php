<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 27.08.2020
 * Time: 01:04
 */

namespace App\Controllers\Front;


use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;


class AuthController extends Controller
{
    protected $auth;
    /**
     * @var Auth
     */
    protected $config;

    /**
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth = service('authentication');
    }


    //--------------------------------------------------------------------
    // Login/out
    //--------------------------------------------------------------------

    /**
     * Displays the login form, or redirects
     * the user to their destination/home if
     * they are already logged in.
     */


    public function login()

    {
        // No need to show a login form if the user
        // is already logged in.
        if ($this->auth->check()) {
            return redirect()->to('/');
        }

        return view('front/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        if ($this->config->validFields == ['email']) {
            $rules['email'] .= '|valid_email';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(422);
        }

        $login = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = (bool)$this->request->getPost('remember');

        // Determine credential type
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Try to log them in...
        if (!$this->auth->attempt([$type => $login, 'password' => $password],$remember)) {
            return $this->response->setJSON([
                'errors' => $this->auth->error() ?? lang('Auth.badAttempt'),
            ])->setStatusCode(422);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => lang('Auth.loginSuccess')
        ])->setStatusCode(200);

    }

    /**
    * Log the user out.
    */
    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to('/');
    }

    public function register()
    {
        // check if already logged in.
        if ($this->auth->check()) {
            return redirect()->to('/');
        }

        return view('front/register');
    }

    /**
     * Displays the user registration page.
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (!$this->config->allowRegistration) {
            return $this->response->setJSON([
                'success' => false,
                'message' => lang('Auth.registerDisabled')
            ])->setStatusCode(403);
        }

        $users = new UserModel();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = [
            'name' => 'required|min_length[3]',
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',

        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => service('validation')->getErrors()
            ])->setStatusCode(422);
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));
        $this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $users->errors()
            ])->setStatusCode(409);
        }

        if ($this->config->requireActivation !== false) {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (!$sent) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $activator->error() ?? lang('Auth.unknownError')
                ])->setStatusCode(503);
            }

            // Success!
            return $this->response->setJSON([
                'success' => true,
                'message' => lang('Auth.activationSuccess')
            ])->setStatusCode(200);
        }

        // Success!
        return $this->response->setJSON([
            'success' => true,
            'message' => lang('Auth.registerSuccess')
        ])->setStatusCode(200);
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
                ->to('front/account/resetpassword')
                ->with('errors', $this->validator->getErrors());

        $oldPassword = base64_encode(
            hash('sha384', $this->request->getPost('old_password'), true)
        );

        if (!password_verify($oldPassword, user()->password_hash))
            return redirect()
                ->to('/front/account/resetPassword')
                ->with('error', 'Eski şifreniz doğru değil');

        $userModel = new UserModel();

        $user = $userModel->find(user_id());
        $user->password = $this->request->getPost('new_password');

        $userModel->save($user);

        return redirect()
            ->to('/front/account/resetpassword')
            ->with('message', 'Şifreniz başarıyla değiştirildi');
    }

}