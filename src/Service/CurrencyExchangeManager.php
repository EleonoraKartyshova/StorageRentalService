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
        //curl_setopt($ch, CURLOPT_URL, 'https://www.xe.com/currencyconverter/convert/?Amount=1&From=USD&To=UAH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        $data = json_decode($response);
    }
}

