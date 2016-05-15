<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;

use RootIndex\Redmine\Lite\Configuration as Config;
use RootIndex\Redmine\Lite\Console\Command\ConfigureCommand;

/**
 * Class Application
 * @package RootIndex\Redmine\Lite
 */
class Application extends \Symfony\Component\Console\Application
{
    const NAME = 'Redmine Lite CLI Tools';
    const VERSION = '1.3.1';

    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);

        $configuration = new Config;

        // Not configured lets configure it
        if (!$configuration->isConfigured()) {
            $this->add(new ConfigureCommand);
            $this->setDefaultCommand('configure');
        }

        // all ready and good to go
        if ($configuration->isConfigured()) {
            $this->addCommands($this->getCommands());
        }

        $this->run();
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        $commands = [];
        $directory = __DIR__ . DIRECTORY_SEPARATOR . 'Console' . DIRECTORY_SEPARATOR . 'Command';
        $directory = new \RecursiveDirectoryIterator($directory);
        $flatFiles = new \RecursiveIteratorIterator($directory);
        $cmdFiles = new \RegexIterator($flatFiles, '/\.(?:php)$/');

        foreach ($cmdFiles as $file) {
            $commandClassName = 'RootIndex\\Redmine\\Lite\Console\\Command\\' . \basename($file, '.php');
            $commands[] = new $commandClassName;
        }
        return $commands;
    }
}
