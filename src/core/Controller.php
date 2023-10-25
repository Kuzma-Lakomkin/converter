<?php 

namespace src\core;

use src\core\View;
use src\lib\Parser;// добавил сюда парсер


class Controller
{
    public $route;
    public $view;
    public $model;
    public $acl;
    public $parser;
    

    public function __construct($route) 
    {
        $this->route = $route; //Тут вот как раз string $route Плюс проверку бы какую-нибудь и исключение типа, если роут пустой типа '' то new InvalidArgumentException
        if (!$this->checkAcl()) {
            View::errorsCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']); //Че если не будет переменной. Будет Notice
        $this->parser = new Parser();
    }


    public function loadModel($name) 
    {
        $path = 'src\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }


    public function checkAcl()
    {
        $this->acl = require '../src/config/acl.php';
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['authorize'])) { 
            return true;
        }
        return false;
    }

    
    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}
