<?php

namespace src\models;

use src\core\Model;
use src\lib\Parser;


class User extends Model
{
    public static array $rates;
    public Parser $parser;
    public array $listRates;


    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser();
    }

    // Добавление данных БД, если БД пустая
    public function addRates(array $params) : array
    {
        foreach ($params as $param) {
            $this->db->query('INSERT INTO exchange_rate 
                            (num_code, char_code, nominal, valute, rate, vunit_rate, update_time)
                            VALUES (:num_code, :char_code, :nominal, :valute, :rate, :vunit_rate, :update_time)', $param);
        }
        return $this->getRates();
    }

    // Получение всех валют из БД
    public function getRates() : array
    {
        if (empty(self::$rates)) {
            User::$rates = $this->db->row('SELECT * FROM exchange_rate');
            return self::$rates;
        } else {
            return self::$rates;
        }
    }


    public function logout() : void
    {
        unset($_SESSION['authorize']);
    }

    // Обновление БД
    public function updateRates() : void
    {
        $params = $this->parser->sendUpdateRateAndVunit();
        foreach ($params as $param) {
            $this->db->query('UPDATE exchange_rate SET  rate = :rate,
                                                        vunit_rate = :vunit_rate,
                                                        update_time = :update_time 
                                                    WHERE valute = :valute', $param);
        }
        return;
    }


    // Проверка пустая ли БД, если нет, то записывает и возвращает данные
    public function checkDatabase() : array
    {
        if (empty($this->getRates())) {
            $params = $this->parser->sendRatesToDatabase();
            $this->listRates = $this->addRates($params);
            return $this->listRates;
        } else {
            $this->listRates = $this->getRates();
            return $this->listRates;
        }
    }
}
