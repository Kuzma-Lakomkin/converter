<?php 

namespace src\lib;

use GuzzleHttp\Client;
use src\models\User;


class Parser
{
    protected Client $client;
    protected string $url;
    public $xml;
    public array $params;

    
    public function __construct()
    {
        $this->client = new Client();
        $this->url = 'http://www.cbr.ru/scripts/XML_daily.asp';
    }
        

    //Метод получения данных с сайта ЦБ
    public function handleRequest() : void
    {
        $response = $this->client->get($this->url);
        if ($response->getStatusCode() == 200) {
            $resbody = $response->getBody()->getContents();
            $this->xml = simplexml_load_string($resbody);
        } else {
            echo "некорректный ответ код ответа: " . $response->getStatusCode();
        }
    }


    //Получение, обработка данных
    public function getDataRates() : void
    {
        $this->handleRequest();
        $this->params = [];
        date_default_timezone_set('Europe/Moscow');
        if ($this->xml) {
            foreach ($this->xml->Valute as $valute) {
                $currentParams = [
                    'num_code' => (string)$valute->NumCode,
                    'char_code' => (string)$valute->CharCode,
                    'nominal' => (string)$valute->Nominal,
                    'valute' => (string)$valute->Name,
                    'rate' => (string)$valute->Value,
                    'vunit_rate' => (string)str_replace(',', '.', $valute->VunitRate),
                    'update_time' => date('Y-m-d H:i:s'),
                ];
                $this->params[] = $currentParams;
            }
        } else {
            echo "XML не загружен или пуст.";
        }
    }


    //Метод возвращает полученные данные из getDataRates
    public function sendRatesToDatabase() : array
    {
        $this->getDataRates();
        return $this->params;
    }


    // Метод возвращает только необходимые данные для обновления курсов валют
    public function sendUpdateRateAndVunit() : array
    {
        $this->getDataRates();
        foreach ($this->params as $value) {
            $updateParams[] = [
                'valute' => $value['valute'],
                'rate' => $value['rate'],
                'vunit_rate' => $value['vunit_rate'],
                'update_time' => $value['update_time'],
            ];
        }
        return $updateParams;
    }
}
