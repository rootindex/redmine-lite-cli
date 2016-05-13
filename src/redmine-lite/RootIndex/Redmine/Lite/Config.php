<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class Config
 * @package RootIndex\Redmine\Lite
 */
class Config
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
     * @throws \Exception
     */
    protected function getConfig()
    {
        $configPath = dirname(dirname(dirname(dirname(dirname(__DIR__)))))
            . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

        if (file_exists($configPath . 'config.ini')) {
            return parse_ini_file($configPath . 'config.ini', true);
        }else{
            throw new \Exception(
                'Please configure your config.ini file!'
            );
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getRedmineUrl()
    {
        $host = '';
        $port = '';
        $proto = 'http://';
        $config = $this->config;

        if(isset($config['redmine.host'])){
            $host = $config['redmine.host'];
        }

        if(isset($config['redmine.port'])){
            $port = in_array($config['redmine.port'], ['80', '443']) ? '' : ':' . $config['redmine.port'];
        }

        if(isset($config['redmine.proto'])){
            $proto = $config['redmine.proto'] . '://';
        }

        if(!isset($host) && !empty($host)){
            throw new \Exception(
                'Please configure your config.ini file!'
            );
        }

        return $proto . $host . $port;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return isset($this->config['redmine.user.token']) ? (string)$this->config['redmine.user.token'] : '';
    }

}