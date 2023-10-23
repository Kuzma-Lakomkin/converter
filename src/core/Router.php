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
            $controllerPath = 'src\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($controllerPath)) {
                $action = $this->params['action'] . "Action";
                if (method_exists($controllerPath, $action)) {
                    $controller = new $controllerPath($this->params);
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
