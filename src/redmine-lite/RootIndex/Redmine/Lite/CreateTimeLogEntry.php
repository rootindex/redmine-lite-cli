<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class CreateTimeLogEntry
 * @package RootIndex\Redmine\Lite
 */
class CreateTimeLogEntry extends AbstractLiteClass implements CreateInterface
{
    /**
     * @var string $ticket
     */
    private $ticket;
    /**
     * @var string $time
     */
    private $time;

    /**
     * @var string $comment
     */
    private $comment;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface $output
     */
    private $output;

    /**
     * CreateTimeLogEntry constructor.
     * @param $ticket
     * @param $time
     * @param string $comment
     * @param $output
     */
    public function __construct($ticket, $time, $comment, $output)
    {
        # clean hash tag ticket numbers
        $this->ticket = str_replace('#', '', $ticket);
        $this->time = $time;
        $this->comment = $comment;
        $this->output = $output;
    }

    /**
     * Create time log entry
     */
    public function create()
    {
        $entry = $this->createTimeLogEntry($this->ticket, $this->time, $this->comment);
        $this->output->writeln(
            "<info>{$entry->comments}</info> completed, entry <comment>#{$entry->id}</comment> successfully created."
        );
    }
}