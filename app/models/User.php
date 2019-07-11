<?php

namespace app\models;

use app\core\Configurable;

class User extends Configurable
{
    public $id;
    public $login;
    public $email;
    public $name;
    private $password;
}
