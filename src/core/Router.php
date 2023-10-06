<?php 

namespace src\core;

use src\core\View;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require '../src/config/routes.php';
        foreach ($arr as $key => $value) {
        $this->add($key, $value);
        }
    }

    public function add($route, $params)
    {
        $route = "#^" . $route . "$#";
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['QUERY_STRING'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                    $this->params = $params;
                    return true;
            }
        }
        return false; 
    }

    public function run()
    {
        if ($this->match()) {
            $controller_path = 'src\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($controller_path)) {
                $action = $this->params['action'] . "Action";
                if (method_exists($controller_path, $action)) {
                    $controller = new $controller_path($this->params);
                    $controller->$action();
                } else {
                    View::errorsCode(404);
                }
            } else {
                View::errorsCode(404);
            }
        } else {
            View::errorsCode(404);
        }
        
    }
}