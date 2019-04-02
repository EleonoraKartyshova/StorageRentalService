<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyExchangeController extends AbstractController
{
    protected $file = "/home/NIX/kartyshova/www/projects/StorageRentalService/src/sync_currency/data.txt";

    /**
     * @Route("/currency/exchange", name="currency_exchange")
     */
    public function currencyExchangeReport()
    {
        $all_lines = file($this->file);
        $last_5 = array_slice($all_lines, -5);

        $currency_reports = [];

        foreach ($last_5 as $key => &$line) {
            $line = explode('_', $line);
            $direction = "—";

            if ($key > 0) {
                if ($line[2] < $last_5[$key-1][2]) {
                    $direction = "down";
                } elseif ($line[2] > $last_5[$key-1][2]) {
                    $direction = 'up';
                } else {
                    $direction = "—";
                }
            }

            $date = substr($line[3], 0, 10) . " " . str_replace("-", ":", substr($line[3], 11, 8));

            $currency_reports[] = ['from' => $line[0], 'to' => $line[1], 'rate' => $line[2], 'date' => $date, 'direction' => $direction];
        }

        return $this->render('page/currency_exchange_report.html.twig', [
            'currency' => 'active',
            'currency_reports' => $currency_reports,
        ]);
    }
}
