<?php 

require('../vendor/autoload.php');
require('../src/lib/Dev.php');

use src\core\Router;

session_start();

$route = new Router;
$route->run();


