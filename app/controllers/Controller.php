<?php

namespace app\controllers;

use app\core\Application;

abstract class Controller
{
    /**
     * @var Application
     */
    protected $app;

    public $title;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function getRequest()
    {
        return $this->getApp()->getRequest();
    }

    public function getApp()
    {
        return $this->app;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function view($template, $params = [])
    {
        $closure = function() use ($template, $params) {
            ob_start();
            extract($params);
            require __DIR__ . '/../views/' . $template;
            return ob_get_clean();
        };

        return $this->wrap($closure());
    }

    private function wrap($content)
    {
        ob_start();
        $title = $this->title;
        require __DIR__ . '/../views/layout.php';
        return ob_get_clean();
    }

    public function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}
