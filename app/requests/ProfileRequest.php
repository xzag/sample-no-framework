<?php

namespace app\requests;

class ProfileRequest extends FormRequest
{
    public $name;
    public $password;

    public function validateData()
    {
        return mb_strlen($this->name) < 255
            && mb_strlen($this->password) < 255;
    }

}
