<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;

class ListUsers extends AbstractLiteClass
{

    public function getUsers($filter)
    {
        $client = $this->getClient();
        return $client->user->all(
            [
                'name' => $filter,
                'status' => 1,
                'limit' => 100
            ]
        );
    }
}
