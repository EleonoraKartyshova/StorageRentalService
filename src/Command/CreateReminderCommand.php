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
use App\Service\RemindManager;

class CreateReminderCommand extends Command
{
    protected static $commandName = 'app:create-remind';
    private $remindManager;

    public function __construct(RemindManager $remindManager)
    {
        $this->remindManager = $remindManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(self::$commandName)
            ->setDescription('Creates a new remind.')
            ->setHelp('This command allows you to create a remind...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Remind Creator',
            '============',
        ]);

        $this->remindManager->getUserEmails();

        $output->writeln('Messages have already been sent!');
    }
}
