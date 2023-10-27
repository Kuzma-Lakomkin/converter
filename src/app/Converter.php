<?php 

namespace src\app;


class Converter
{
    public $userRates;


    public function __construct($userRates)
    {
        $this->userRates = $userRates;
    }

    //Добавление рублей к массиву со всеми спаршенными валютами
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

        $this->userRates[] = $ruble;
        return $this->userRates;
    }


    // Конвертер
    public function converterCurrency()
    {
        if (!empty($_POST)) {
            $fromCurrency = $_POST['from_currency'];
            $fromValue = $_POST['from'];
            if (isset($_POST['to_currency'])) {
                $toCurrency = $_POST["to_currency"];
            } else {
                $toCurrency = 643;
            }

            foreach ($this->userRates as $item) {
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
}
