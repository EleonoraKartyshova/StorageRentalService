<?php
/**
 * Created by PhpStorm.
 * User: eleonora
 * Date: 28.02.19
 * Time: 19:39
 */

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CurrencyExchangeManager extends AbstractController
{
    const PATH = __DIR__.'/../../data/';
    const CURRENCY_DIR = 'sync_currency/';
    const CURRENCY_FILE = 'data.txt';

    public function currencyExchange()
    {
        $this->createDir();
        $this->createFile();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://free.currencyconverterapi.com/api/v5/convert?q=USD_UAH&compact=y&apiKey=809e02e97aee8badec89');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $data = json_decode($response, true);

        $data_text = "";
        foreach ($data as $key => $value) {
            $data_text .= $key . "_" . $value['val'] . "_" . date("Y-m-d-H-i-s") . "\n";
        }

        file_put_contents(self::PATH.self::CURRENCY_DIR.self::CURRENCY_FILE, $data_text, FILE_APPEND);
    }

    public function createDir()
    {
        if (!file_exists(self::PATH.self::CURRENCY_DIR)) {
            mkdir(rtrim(self::PATH.self::CURRENCY_DIR,'/'), 0777);
        }
    }

    public function createFile()
    {
        if (!file_exists(self::PATH.self::CURRENCY_DIR.self::CURRENCY_FILE)) {
            fopen(self::PATH.self::CURRENCY_DIR.self::CURRENCY_FILE, "a+");
        }
    }
}
