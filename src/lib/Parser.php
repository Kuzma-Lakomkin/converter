<?php 

namespace src\lib;
use GuzzleHttp\Client;

class Parser
{
    protected $client;
    protected $url;
    public $xml;
    public $params;

    
    public function __construct()
    {
        $this->client = new Client();
        $this->url = 'http://www.cbr.ru/scripts/XML_daily.asp';
    }
        
    public function handleRequest()
    {
        $response = $this->client->get($this->url);
        if ($response->getStatusCode() == 200) {
            $resbody = $response->getBody()->getContents();
            $this->xml = simplexml_load_string($resbody);
        } else {
            echo "некорректный ответ код ответа: " . $response->getStatusCode();
        }
    }

    public function getDataRates()
    {
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
                    'vunit_rate' => (string)$valute->VunitRate,
                    'update_time' => date('Y-m-d H:i:s'),
                ];
                $this->params[] = $currentParams;
            }
        } else {
            echo "XML не загружен или пуст.";
        }
    }
}