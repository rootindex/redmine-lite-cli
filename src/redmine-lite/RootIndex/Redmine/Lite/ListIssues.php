<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class ListIssues
 * @package RootIndex\Redmine\Lite
 */
class ListIssues extends AbstractLiteClass
{
    /**
     * @param $arguments
     * @return array
     */
    public function getIssues($arguments)
    {
        $client = $this->getClient();
        return $client->issue->all($arguments);
    }
}