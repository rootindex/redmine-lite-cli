<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite\Console\Command;

use RootIndex\Redmine\Lite\TicketFunctions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PauseTicketCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class PauseTicketCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ticket:pause')
            ->setDescription('Pause a ticket')
            ->addArgument('ticket', InputArgument::REQUIRED, 'Redmine ticket number');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ticket = $input->getArgument('ticket');

        if ($ticket) {
            $startFactory = new TicketFunctions();
            $startFactory->pause($ticket);
            $output->writeln("Ticket <comment>#{$ticket}</comment> paused");
        }
    }
}
