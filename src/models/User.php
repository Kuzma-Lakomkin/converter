<?php 

namespace src\models;

use src\core\Model;


class User extends Model
{
    public static $rates;


    public function addRates($params)
    {
        foreach ($params as $param) {
            $this->db->query('INSERT INTO exchange_rate 
                            (num_code, char_code, nominal, valute, rate, vunit_rate, update_time)
                            VALUES (:num_code, :char_code, :nominal, :valute, :rate, :vunit_rate, :update_time)', $param);
        }
        return $this->getRates();
    }


    public function getRates()
    {
        if (empty(self::$rates)) {
            User::$rates = $this->db->row('SELECT * FROM exchange_rate');
            return self::$rates;
        } else {
            return self::$rates;
        }
    }


    public function addRubles()
    {   
        $this->getRates();

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

        self::$rates[] = $ruble;
        return self::$rates;
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

            foreach (self::$rates as $item) {
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
}   
