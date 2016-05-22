<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;
/**
 * Class StartTicket
 * @package RootIndex\Redmine\Lite
 */
class StartTicket extends AbstractLiteClass
{
    /**
     * @param $ticket
     * @return \Redmine\Api\SimpleXMLElement
     */
    public function start($ticket)
    {
        $client = $this->getClient();
        return $client->issue->update(
            $ticket,
            [
                'status' => 'In Progress',
                //'status_id' => '2',
                'notes' => 'Started work on ticket ' . $ticket,
                'private_notes' => true
            ]
        );
    }
}
