<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SubTicketsExampleCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class SubTicketsExampleCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('subs:example')
            ->setDescription('Sub tickets example json file')
            ->addOption('save-file', null, InputOption::VALUE_OPTIONAL, 'Save to specified file');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getOption('save-file');
        $json = $this->getExampleJson();

        if ($fileName) {
            try {
                file_put_contents($fileName, $json);
                $output->writeln("Saved example file: <comment>{$fileName}</comment>");

            } catch (\Exception $e){
                throw new \Exception($e);
            }
        }

        if(!$fileName){
            $output->writeln('<comment>Example json:</comment>');
            $output->writeln($json);
        }
    }

    /**
     * @return string
     */
    private function getExampleJson()
    {
        return '{
  "10000": [
    {
      "task": "Example sub-ticket subject estimate only",
      "time": "9m"
    },
    {
      "task": "Example sub-ticket for #10000 estimate & auto time logged",
      "time": "9m:3m"
    }
  ],
  "10001": [
    {
      "task": "Example sub-ticket for #10001"
    }
  ]
}';
    }
}