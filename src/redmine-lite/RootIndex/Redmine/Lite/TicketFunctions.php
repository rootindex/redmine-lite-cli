<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;

/**
 * Class TicketFunctions
 * @package RootIndex\Redmine\Lite
 */
class TicketFunctions extends AbstractLiteClass
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
                'done_ratio' => '10',
                'notes' => 'Started work on ticket #' . $ticket,
                'private_notes' => true,
            ]
        );
    }
    /**
     * @param $ticket
     * @return \Redmine\Api\SimpleXMLElement
     */
    public function pause($ticket)
    {
        $client = $this->getClient();
        return $client->issue->update(
            $ticket,
            [
                'status' => 'On Hold',
                'done_ratio' => '50',
                'notes' => 'Paused work on ticket #' . $ticket,
                'private_notes' => true,
            ]
        );
    }

}
