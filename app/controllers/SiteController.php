<?php

namespace app\controllers;

class SiteController extends Controller
{
    public function index()
    {
        return $this->view('site/index.php');
    }
}
