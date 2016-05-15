<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class Configuration
 * @package RootIndex\Redmine\Lite
 */
class Configuration
{
    /**
     * configuration file name
     */
    const FILE = '.redmine-lite';

    /**
     * @var array
     */
    private $config;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
    }

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

    /**
     * @return array
     */
    protected function getConfig()
    {
        $json = \file_get_contents($this->getConfigFile());
        return \json_decode($json, true);
    }

    /**
     * @return string
     */
    public function getRedmineUrl()
    {
        return isset($this->config['server']) ? (string)$this->config['server'] : '';
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return isset($this->config['token']) ? (string)$this->config['token'] : '';
    }
}
