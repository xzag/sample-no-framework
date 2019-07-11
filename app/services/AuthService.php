<?php

namespace app\services;

use app\models\User;

class AuthService
{
    private $_userService;

    public function __construct($userService)
    {
        $this->_userService = $userService;
    }

    public function authenticate($user)
    {
        $_SESSION['user_id'] = $user->id;
    }

    public function isAuthorized()
    {
        return !empty($_SESSION['user_id']);
    }

    /**
     * @return User|bool
     */
    public function getUser()
    {
        if (!$this->isAuthorized()) {
            return false;
        }

        return $this->_userService->getById($_SESSION['user_id']);
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }
}
