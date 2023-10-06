<?php 

namespace src\core;


class View
{
    public $path;
    public $route;
    public $layout = 'default.php';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $this->route['controller'] . '/'. $this->route['action'] . '.php';
    }

    public function render($title, $vars= [])
    {   
        extract($vars);
        $views_path = '../src/views/' . $this->path;
        if (file_exists($views_path)) {
            ob_start();
            require $views_path;
            $content = ob_get_clean();
            require '../src/views/layouts/' . $this->layout;
        } else {
            echo 'Вид не найден';
        }
    }

    public function redirect($url)
    {
        header('location:', $url);
    }

    public static function errorsCode($code)
    {
        http_response_code($code);
        require '../src/views/errors/' . $code . '.php';
        exit;
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }
}
