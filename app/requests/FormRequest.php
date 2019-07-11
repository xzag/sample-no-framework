<?php

namespace app\requests;

use app\core\Application;
use app\core\Configurable;

class FormRequest extends Configurable
{
    public $csrf;

    public static function make(array $data, $callback = null)
    {
        return parent::make($data, 'trim');
    }

    public function validateData()
    {
        return true;
    }

    public function validateCSRF()
    {
        if (!hash_equals(Application::get()->getCSRF(), $this->csrf)) {
            return false;
        }

        Application::get()->refreshCSRF(true);
        return true;
    }

    public function validate()
    {
        if (!$this->validateCSRF()) {
            return false;
        }

        return $this->validateData();
    }
}
