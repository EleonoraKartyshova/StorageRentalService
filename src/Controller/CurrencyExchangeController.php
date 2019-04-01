<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyExchangeController extends AbstractController
{
    /**
     * @Route("/currency/exchange", name="currency_exchange")
     */
    public function currencyExchangeReport()
    {
        return $this->render('page/currency_exchange_report.html.twig', [
            'currency' => 'active',
        ]);
    }
}
