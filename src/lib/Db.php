<?php 

namespace src\lib;

use PDO;


class Db
{
    protected PDO $db;


    public function __construct()
    {
        $config = require(__DIR__.'/../config/db.php');
        $this->db = new PDO('mysql:host=' . $config['host'] . 
                            ';port=' . $config['port'] .
                            ';dbname='. $config['dbname'],
                            $config['user'],
                            $config['pass']);
    }


    public function query(string $sql, array $params = [])
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


    public function row(string $sql, array $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    public function column(string $sql, array $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }
}
