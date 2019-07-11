<?php

namespace app\core;

use app\exceptions\Exception;
use app\exceptions\HttpException;
use app\exceptions\NotFoundException;

class Application
{
    private $_csrf;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Route[]
     */
    private $_routes;

    /**
     * @var \PDO
     */
    private $_connection;

    /**
     * @var static
     */
    private static $_instance;

    private function __construct()
    {

    }

    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        if (!isset($this->_connection)) {
            $dbHost = getenv('DB_HOST');
            $dbName = getenv('DB_NAME');
            $this->_connection = new \PDO("mysql:host={$dbHost};dbname={$dbName}", getenv('DB_USER'), getenv('DB_PASS'));
        }

        return $this->_connection;
    }

    public static function get()
    {
        if (!isset(static::$_instance)) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public function addRoute($method, $path, $controller, $action)
    {

        $this->_routes[] = Route::make([
            'method' => mb_strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ]);
        return true;
    }

    /**
     * @param $request
     * @return Route|false
     */
    private function findRoute($request)
    {
        foreach ($this->_routes as $route) {
            if ($route->path === $request->getPath() && ($route->method === '*' || $route->method === $request->getMethod())) {
                return $route;
            }
        }

        return false;
    }

    /**
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     * @throws Exception
     */
    public function errorHandler($code, $message, $file, $line)
    {
        throw new Exception("$message in $file on line $line", 0);
    }

    /**
     * @param Exception $e
     */
    public function exceptionHandler($e)
    {
        if ($e instanceof HttpException) {
            http_response_code($e->getStatus());
        } else {
            http_response_code(500);
        }
        print get_class($e).": Message: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}";
    }

    public function init()
    {
        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));
    }

    public function refreshCSRF($force = false)
    {
        if (empty($_SESSION['csrf']) || $force) {
            $_SESSION['csrf'] = md5(uniqid(rand(), TRUE));
        }
        $this->_csrf = $_SESSION['csrf'];
        return $this->_csrf;
    }

    public function getCSRF()
    {
        return $this->_csrf;
    }

    public function run()
    {
        session_start();
        $this->init();
        $this->refreshCSRF();

        $this->_request = new Request($_REQUEST);
        require __DIR__ . '/../routes/map.php';

        $route = $this->findRoute($this->_request);
        if (!$route) {
            throw new NotFoundException("Route {$this->_request->getPath()} not found");
        }

        $controller = new $route->controller($this);
        $action = $route->action;

        $response = $controller->$action();
        echo $response;
    }
}
