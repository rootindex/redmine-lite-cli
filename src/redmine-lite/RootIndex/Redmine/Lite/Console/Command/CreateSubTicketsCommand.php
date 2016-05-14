<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RootIndex\Redmine\Lite\CreateSubTickets;

/**
 * Class CreateSubTicketsCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class CreateSubTicketsCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sub-tickets')
            ->setDescription('Generate sub tickets from json file')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'Please specify the json file'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        // safety check
        if ($file) {
            $create = new CreateSubTickets($file, $output);
            $create->create();
        }
    }
}