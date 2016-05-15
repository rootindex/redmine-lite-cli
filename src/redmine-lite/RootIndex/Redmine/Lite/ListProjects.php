<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;

class ListProjects extends AbstractLiteClass
{

    public function getProjects($limit)
    {
        $client = $this->getClient();

        $arguments = [
            'include' => 'trackers'
        ];

        if (isset($limit) && is_numeric($limit)) {
            $arguments['limit'] = $limit;
        }

        return $client->project->all($arguments);
    }
}
