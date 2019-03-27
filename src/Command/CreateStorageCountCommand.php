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
use App\Service\StorageCountManager;

class CreateStorageCountCommand extends Command
{
    protected static $commandName = 'app:increment-storage-count';
    private $storageCountManager;

    public function __construct(StorageCountManager $storageCountManager)
    {
        $this->storageCountManager = $storageCountManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::$commandName)
            ->setDescription('Increment storage count at the expiration of the reservation.')
            ->setHelp('This command allows you to increment storage count at the expiration of the reservation...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Increment storage count Creator',
            '============',
        ]);

        $this->storageCountManager->incrementStorageCount();

        $output->writeln('Storage counts have already been incremented!');
    }
}

