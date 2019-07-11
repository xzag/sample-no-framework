<?php

namespace app\controllers;

use app\exceptions\UnathorizedException;
use app\requests\ProfileRequest;
use app\services\AuthService;
use app\services\UserService;

class UserController extends Controller
{
    /**
     * @var AuthService
     */
    private $_authService;

    /**
     * @var UserService
     */
    private $_userService;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->_userService = new UserService($app->getConnection());
        $this->_authService = new AuthService($this->_userService);
    }

    public function profile()
    {
        $user = $this->_authService->getUser();
        if (!$user) {
            $this->redirect('/auth/login');
        }

        $request = $this->getRequest();
        $error = '';
        if ($request->isPost()) {
            $profileRequest = ProfileRequest::make($request->post());
            if (!$profileRequest->validate()) {
                $error = 'Check required input';
            } else {
                if ($this->_userService->update($user->id, $profileRequest)) {
                    $this->redirect('/user/profile');
                } else {
                    $error = 'Failed to update user';
                }
            }
        } else {
            $profileRequest = ProfileRequest::make([
                'name' => $user->name,
            ]);
        }

        return $this->view('user/profile.php', ['user' => $user, 'error' => $error, 'request' => $profileRequest]);
    }
}
