<?php

namespace RootIndex\Redmine\Lite;

/**
 * Class CreateTree
 * @package RootIndex\Redmine\Lite
 */
class CreateSubTickets extends AbstractLiteClass implements CreateInterface
{
    /**
     * @var string
     */
    private $jsonFile;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface $output
     */
    private $output;

    /**
     * CreateTree constructor.
     * @param $jsonFile
     * @param $output
     */
    public function __construct($jsonFile, $output)
    {
        $this->jsonFile = $jsonFile;
        $this->output = $output;
    }

    /**
     * Create tickets
     * @throws \Exception
     */
    public function create()
    {
        $parentTickets = $this->getDataFromJsonString();
        foreach ($parentTickets as $parentTicketsNumber => $tickets) {

            $parent = $this->getTicket($parentTicketsNumber);

            if (!$parent) {
                throw new \Exception('Ticket does not exist: ' . $parentTicketsNumber);
            }

            foreach ($tickets as $ticket) {
                $time = isset($ticket['time']) ? $ticket['time'] : false;
                $time = explode(':', $time);
                $timeRequired = isset($time[0]) ? $time[0] : null;
                $timeSpend = isset($time[1]) ? $time[1] : null;

                /** @var \Redmine\Api\SimpleXMLElement $newTicket */
                $newTicket = $this->createTicket($ticket['task'], $parent, $timeRequired);

                $this->output->writeln(
                    "<info>#{$parentTicketsNumber}</info> :: Created sub-ticket: <comment>#{$newTicket->id}</comment> :: {$ticket['task']} "
                );

                if ($timeSpend) {
                    $this->createTimeLogEntry($newTicket->id, $timeSpend);
                }
            }
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getDataFromJsonString()
    {
        $data = \json_decode($this->loadJsonStringFromFile(), true);
        if ($data === false) {
            throw new \Exception('Json contents within file is not valid!');
        }
        return $data;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function loadJsonStringFromFile()
    {
        if (!\is_file($this->jsonFile)) {
            throw new \Exception('Specified file does not exist: ' . $this->jsonFile);
        }
        return \file_get_contents($this->jsonFile);
    }
}