<?php

namespace app\core;

class Route extends Configurable
{
    public $method;
    public $path;
    public $controller;
    public $action;

    public static function any($path, $controller, $action)
    {
        return Application::get()->addRoute('*', $path, $controller, $action);
    }

    public static function get($path, $controller, $action)
    {
        return Application::get()->addRoute('get', $path, $controller, $action);
    }

    public static function post($path, $controller, $action)
    {
        return Application::get()->addRoute('post', $path, $controller, $action);
    }
}
