<?php 

namespace src\models;

use src\core\Model;
use src\lib\Parser;


class User extends Model
{
    protected $parser;
    protected $rates;


    public function __construct()
    {
        parent::__construct();
        $this->parser = new Parser;

        $this->rates = $this->db->row('SELECT * FROM exchange_rate'); // при инициализации класса тащится вся таблица
    }


    public function addRates()
    {
        $this->parser->handleRequest(); //Скорее сервис должен использовать модель, а не наоборот. Так как модель представляет собой структуру данных, которую ты можешь использовать бизнес логике сервиса. Пример: одна модель может использоваться в твоем сервисе и в будущем в админке
        $this->parser->getDataRates();
        foreach ($this->parser->params as $param) {
            $this->db->query('INSERT INTO exchange_rate 
                            (num_code, char_code, nominal, valute, rate, vunit_rate, update_time)
                            VALUES (:num_code, :char_code, :nominal, :valute, :rate, :vunit_rate, :update_time)', $param);
        }
        return $this->rates;
        
    }


    public function getRates()
    {
        if (!empty($this->rates)) {
            return $this->rates;
        } else {
            return $this->addRates();
        }
    }


    public function addRubles()
    {   
        $ruble = [
            'id' => 44,
            'num_code' => '643',
            'char_code' => 'RUB',
            'nominal' => 1,
            'valute' => 'Российский рубль',
            'rate' => 1, 
            'vunit_rate' => 1,
            'update_time' => date('Y-m-d H:i:s'),
        ];

        $this->rates[] = $ruble;
        return $this->rates;
    }


    public function converter()
    {
        if (!empty($_POST)) {
            $fromCurrency = $_POST['from_currency'];
            $fromValue = $_POST['from'];
            if (isset($_POST['to_currency'])) {
                $toCurrency = $_POST["to_currency"];
            } else {
                $toCurrency = 643;
            }

            foreach ($this->rates as $item) {
                if ($fromCurrency != 643) {
                    if ($item['num_code'] == $fromCurrency) {
                        $vunit_rate = $item['vunit_rate'];
                        $amount = round($vunit_rate * $fromValue, 4);
                        $result = ['amount' => $amount];
                    }
                } elseif ($item['num_code'] == $toCurrency) {
                    $vunit_rate = $item['vunit_rate'];
                    $amount = round($fromValue / $vunit_rate, 4);
                    $result = ['amount' => $amount];
                }
            }
        }   
        header('Content-Type: application/json');
        echo json_encode($result);    
    }


    public function logout()
    {
        unset($_SESSION['authorize']);
    }


    public function updateRates()
    {
        if (!empty($this->rates)) {
            $this->parser->handleRequest();
            $this->parser->getDataRates();
            foreach ($this->parser->params as $valute) {
                $this->db->query('UPDATE exchange_rate SET rate = :rate, vunit_rate = :vunit_rate, update_time = :update_time', $valute);
                return;
            }
        }
    }
}   
