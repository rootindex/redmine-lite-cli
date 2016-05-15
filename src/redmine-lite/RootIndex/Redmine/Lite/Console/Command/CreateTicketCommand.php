<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RootIndex\Redmine\Lite\CreateTicket;

/**
 * Class CreateTicketCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class CreateTicketCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('create-ticket')
            ->setDescription('Create a ticket');
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $options = $input->getOptions();

        $create = new CreateTicket($options, $output);
        $create->create();
    }
}
