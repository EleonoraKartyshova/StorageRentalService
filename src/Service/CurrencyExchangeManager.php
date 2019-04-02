<?php
/**
 * Created by PhpStorm.
 * User: eleonora
 * Date: 28.02.19
 * Time: 19:39
 */

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;

class CurrencyExchangeManager extends AbstractController
{
    protected $path = '/home/NIX/kartyshova/www/projects/StorageRentalService/src/';

    public function currencyExchange()
    {
        if (!file_exists($this->path . 'sync_currency/')) {
            mkdir($this->path . 'sync_currency', 0777);
            echo "The directory was successfully created. ";
        } else {
            echo "The directory exists.";
        }

        if (!file_exists($this->path . 'sync_currency/data.txt')) {
            $file = fopen($this->path . "sync_currency/data.txt", "a+");
            echo "The file was successfully created. ";
        } else {
            echo "The file exists.";
        }

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

        file_put_contents($this->path . "sync_currency/data.txt", $data_text, FILE_APPEND);
    }
}
