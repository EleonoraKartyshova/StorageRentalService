<?php
/**
 * Created by PhpStorm.
 * User: eleonora
 * Date: 28.02.19
 * Time: 19:22
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\CurrencyExchangeManager;

class CreateCurrencyExchangeCommand extends Command
{
    protected static $commandName = 'app:get-currency-exchange';
    private $currencyExchangeManager;

    public function __construct(CurrencyExchangeManager $currencyExchangeManager)
    {
        $this->currencyExchangeManager = $currencyExchangeManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::$commandName)
            ->setDescription('Get currency exchange.')
            ->setHelp('This command allows you to get currency exchange and write data in file...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Get currency exchange Creator',
            '============',
        ]);

        $this->currencyExchangeManager->currencyExchange();

        $output->writeln('Currency exchange has already been added!');
    }
}

