<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class Config
 * @package RootIndex\Redmine\Lite
 */
class Config extends ConfigureConfig
{

    /**
     * @var array
     */
    private $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
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
     * @throws \Exception
     */
    public function getRedmineUrl()
    {
        $server = '';
        $config = $this->config;

        if (isset($config['server'])) {
            $server = $config['server'];
        }

        if (!isset($server) && empty($server)) {
            throw new \Exception(
                'Please re-configure setup run configure!'
            );
        }
        return $server;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return isset($this->config['token']) ? (string)$this->config['token'] : '';
    }
}
