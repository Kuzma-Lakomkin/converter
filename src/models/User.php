<?php 

namespace src\models;

use src\core\Model;
use src\lib\Parser;


class User extends Model
{
    protected $parser;
    protected $result;

    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser;
        $this->result = $this->db->row('SELECT * FROM exchange_rate');
    }
    public function getRates()
    {
        if (!empty($this->result)) {
            return $this->result;
        } else {
            return $this->addRates();
        }
    }

    public function addRates()
    {
        $this->parser->handleRequest();
        $this->parser->getDataRates();
        foreach ($this->parser->params as $param) {
            $this->db->query('INSERT INTO exchange_rate 
                            (num_code, char_code, nominal, valute, rate, vunit_rate, update_time)
                            VALUES (:num_code, :char_code, :nominal, :valute, :rate, :vunit_rate, :update_time)', $param);
        }
        $result = $this->db->row('SELECT * FROM exchange_rate');
        return $result;
    }

    public function converter()
    {
    }
}   
