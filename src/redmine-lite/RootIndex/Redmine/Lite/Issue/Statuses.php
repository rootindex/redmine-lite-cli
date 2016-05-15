<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite\Issue;

/**
 * Class Statuses
 * @package RootIndex\Redmine\Lite\Issue
 */
class Statuses implements IssueInterface
{
    /** @var \RootIndex\Redmine\Lite\ListIssues $context */
    private $context;

    /**
     * Statuses constructor.
     * @param $context
     */
    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $client = $this->context->getClient();
        $statuses = $client->issue_status->listing();

        if (!empty($statuses)) {
            return array_flip($statuses);
        }
        return [];
    }
}
