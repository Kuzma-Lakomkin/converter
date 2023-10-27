<?php 

namespace src\core;

use src\lib\Db;


abstract class Model
{
    public Db $db;
    public array $errors;

    
    public function __construct()
    {
        $this->db = new Db();
    }
}
