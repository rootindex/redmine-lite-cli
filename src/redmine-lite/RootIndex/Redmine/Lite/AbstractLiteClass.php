<?php

namespace RootIndex\Redmine\Lite;

use Redmine\Client;

/**
 * Class AbstractLiteClass
 * @package RootIndex\Redmine\Lite
 */
abstract class AbstractLiteClass implements LiteClassInterface
{
    /**
     * @var
     */
    protected $config;
    /**
     * @var
     */
    protected $client;

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        if (!$this->config) {
            $this->config = new Configuration;
        }
        return $this->config;
    }

    /**
     * @return Client
     * @throws \Exception
     */
    public function getClient()
    {
        if (!$this->client) {
            $config = $this->getConfig();
            $this->client = new Client($config->getRedmineUrl(), $config->getAccessToken());
        }
        return $this->client;
    }

    /**
     * @param $ticketId
     * @param $time
     * @param $comment
     * @return \Redmine\Api\SimpleXMLElement
     * @throws \Exception
     */
    public function createTimeLogEntry($ticketId, $time, $comment = false)
    {
        $client = $this->getClient();
        $ticket = $this->getTicket($ticketId);
        $timeEntry = [
            'issue_id' => $ticketId,
            'project_id' => $ticket['project']['id'],
            'hours' => $time,
            'activity_id' => 9, // @TODO Hardcoded as Development for now
            'comments' => "Auto-log: #{$ticketId}",
        ];

        if ($comment) {
            $timeEntry['comments'] = "#{$ticketId} {$comment}";
        }

        return $client->time_entry->create($timeEntry);
    }


    /**
     * @param string $identifier
     * @return mixed
     */
    public function getTicket($identifier)
    {
        $client = $this->getClient();
        $issue = $client->issue->show($identifier);
        return isset($issue['issue']) ? $issue['issue'] : false;
    }

    /**
     * @return integer
     */
    public function getCurrentUserId()
    {
        $user = $this->getClient()->user->getCurrentUser();
        return $user['user']['id'];
    }

    /**
     * @param string $title
     * @param $parent
     * @param null $estimate
     * @return \Redmine\Api\SimpleXMLElement
     */
    public function createSubTicket($title, $parent, $estimate = null)
    {
        $client = $this->getClient();

        $newTicketData = [
            'subject' => $title,
            'description' => "This ticket was created to track time for #{$parent['id']}",
            'project_id' => $parent['project']['id'],
            'tracker_id' => $parent['tracker']['id'],
            'status_id' => 5, // [Closed] by default as I don't want to get flooded
            'priority_id' => $parent['priority']['id'],
            'parent_issue_id' => $parent['id'],
            'estimated_hours' => $estimate,
            'done_ratio' => 100,
            'assigned_to_id' => $this->getCurrentUserId(),
            'author_id' => $this->getCurrentUserId()
        ];

        return $client->issue->create($newTicketData);
    }
}
