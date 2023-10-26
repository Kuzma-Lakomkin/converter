<?php 

namespace src\core;

use src\core\View;


class Controller
{
    public array $route;
    public View $view;
    public $model;
    public array $acl;
    

    public function __construct(array $route) 
    {
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorsCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']); 
    }


    public function loadModel(string $name)
    {
        $path = 'src\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }


    public function checkAcl() : bool
    {
        $this->acl = require '../src/config/acl.php';
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['authorize'])) { 
            return true;
        }
        return false;
    }

    
    public function isAcl(string $key) : bool
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
