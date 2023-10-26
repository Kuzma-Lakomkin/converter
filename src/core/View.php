<?php 

namespace src\core;


class View
{
    public string $path;
    public array $route;
    public string $layout = 'default.php';


    public function __construct(array $route)
    {
        $this->route = $route;
        $this->path = $this->route['controller'] . '/'. $this->route['action'] . '.php';
    }


    public function render(string $title, array $vars= [], $template=false)
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


    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    
    public static function errorsCode(int $code)
    {
        http_response_code($code);
        require '../src/views/errors/' . $code . '.php';
        exit;
    }
}
