<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class ConfigureConfig
 * @package RootIndex\Redmine\Lite
 */
class ConfigureConfig
{
    /**
     * configuration file name
     */
    const FILE = '.redmine-lite';

    /**
     * @return string
     */
    public function getConfigFile()
    {
        return \getenv('HOME') . DIRECTORY_SEPARATOR . self::FILE;
    }

    /**
     * @return bool
     */
    public function isConfigured()
    {
        return \file_exists($this->getConfigFile());
    }

    /**
     * @param $configs
     */
    public function save($configs)
    {
        \file_put_contents($this->getConfigFile(), \json_encode($configs));
    }
}
