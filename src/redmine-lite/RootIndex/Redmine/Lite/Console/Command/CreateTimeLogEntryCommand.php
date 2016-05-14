<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RootIndex\Redmine\Lite\CreateTimeLogEntry;

/**
 * Class CreateTimeLogEntryCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class CreateTimeLogEntryCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('log-time')
            ->setDescription('Log time per ticket')
            ->addArgument(
                'ticket',
                InputArgument::REQUIRED,
                'Ticket number <comment>[example: 10000 or #10001]</comment>'
            )
            ->addArgument(
                'time',
                InputArgument::REQUIRED,
                'Time <comment>[example: 1d2h3m or 0.15]</comment>'
            )
            ->addOption(
                'comment',
                '-c',
                InputArgument::OPTIONAL,
                'Custom Comment Auto-log will be over written'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ticket = $input->getArgument('ticket');
        $time = $input->getArgument('time');
        $comment = $input->getOption('comment');
        // safety check
        if ($ticket && $time) {
            $create = new CreateTimeLogEntry($ticket, $time, $comment, $output);
            $create->create();
        }
    }
}