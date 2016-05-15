<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

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

        $args = [
            'assigned_to_id' => $this->getUserId($arguments['user']),
            'project_id' => $this->getProjectId($arguments['project']),
            'limit' => $arguments['limit'],
            'status_id' => $arguments['status']
        ];

        return $client->issue->all($args);
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function getProjectId($identifier)
    {
        if ($identifier == 'all') {
            return null;
        }
        return $identifier;
    }

    /**
     * @param $identifier
     * @return null|int
     */
    public function getUserId($identifier)
    {
        if ($identifier == 'all') {
            return null;
        }

        $myself = $identifier == '0' || $identifier == 'me';
        // if current user
        if ($myself) {
            return $this->getCurrentUserId();
        }
        // not current user
        if (!$myself) {

            if (!is_numeric($identifier)) {
                return $this->getClient()->user->getIdByUsername($identifier);
            }
            if (is_numeric($identifier)) {
                return $identifier;
            }
        }
        return null;
    }
}
