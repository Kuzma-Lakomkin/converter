<?php 

namespace src\lib;

use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $config = require '../src/config/db.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . 
                            ';dbname='. $config['dbname'],
                            $config['user'],
                            $config['pass']);
    }

    public function query($sql, $params = [])
    {
        $query = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $query->bindValue(':' . $key, $value);
            }
        }
        $query->execute();
        return $query;
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}