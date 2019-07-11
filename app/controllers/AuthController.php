<?php

namespace app\controllers;

use app\requests\FormRequest;
use app\requests\SignupRequest;
use app\services\AuthService;
use app\services\UserService;

class AuthController extends Controller
{
    private $_userService;
    private $_authService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->_userService = new UserService($app->getConnection());
        $this->_authService = new AuthService($this->_userService);
    }

    public function login()
    {
        $user = $this->_authService->getUser();
        if ($user) {
            $this->redirect('/user/profile');
        }

        $request = $this->getRequest();
        $error = '';
        if ($request->isPost()) {

            if ($user = $this->_userService->findByCredentials($request->post('login'), $request->post('password'))) {
                $this->_authService->authenticate($user);
                $this->redirect('/user/profile');
            } else {
                $error = 'Invalid login or password';
            }
        }
        return $this->view('auth/login.php', ['error' => $error]);
    }

    public function signup()
    {
        $user = $this->_authService->getUser();
        if ($user) {
            $this->redirect('/user/profile');
        }

        $request = $this->getRequest();
        $error = '';
        if ($request->isPost()) {
            $signupRequest = SignupRequest::make($request->post());
            if (!$signupRequest->validate()) {
                $error = 'Check required input';
            } else {
                if (!$user = $this->_userService->findByEmailOrLogin($signupRequest->email, $signupRequest->login)) {
                    if ($this->_userService->make($signupRequest)) {
                        $this->redirect('/auth/login');
                    } else {
                        $error = 'Failed to signup user';
                    }
                } else {
                    $error = 'User with email or login already exists';
                }
            }
        } else {
            $signupRequest = new SignupRequest();
        }
        return $this->view('auth/signup.php', ['error' => $error, 'request' => $signupRequest]);
    }

    public function logout()
    {
        $request = FormRequest::make($this->getRequest()->post());
        if (!$request->validate()) {
            $this->redirect('/user/profile');
        }

        $this->_authService->logout();
        $this->redirect('/');
    }
}
