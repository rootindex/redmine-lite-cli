<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite;

/**
 * Class CreateTicket
 * @package RootIndex\Redmine\Lite
 */
class CreateTicket extends AbstractLiteClass implements CreateInterface
{

    private $output;
    private $options;

    /**
     * CreateTicket constructor.
     * @param array $options
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct($options, $output)
    {
        $this->options = $options;
        $this->output = $output;
    }

    public function create()
    {
        $this->output->writeln('Sorry functionality omitted for now goto: ' . $this->getConfig()->getRedmineUrl());
    }
}
