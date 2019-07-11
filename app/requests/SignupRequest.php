<?php

namespace app\requests;

class SignupRequest extends FormRequest
{
    public $login;
    public $email;
    public $name;
    public $password;

    public function validateData()
    {
        return !empty($this->login) && mb_strlen($this->login) < 255
            && !empty($this->email) && mb_strlen($this->email) < 255
            && mb_strlen($this->name) < 255
            && !empty($this->password) && mb_strlen($this->password) < 255;
    }

}
