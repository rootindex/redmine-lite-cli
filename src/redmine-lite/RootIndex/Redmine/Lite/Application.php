<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class Application
 * @package RootIndex\Redmine\Lite
 */
class Application extends \Symfony\Component\Console\Application
{
    const NAME = 'Redmine Lite CLI Tools';
    const VERSION = '1.1.0';

    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
        $this->addCommands($this->getCommands());
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
