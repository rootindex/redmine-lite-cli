<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use RootIndex\Redmine\Lite\ListIssues;

class ListIssuesCommand extends Command
{
    /**
     * @var ListIssues
     */
    private $issuesFactory;

    /**
     * ListIssuesCommand constructor.
     */
    public function __construct()
    {
        $this->issuesFactory = new ListIssues;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('issues')
            ->setAliases(['tickets'])
            ->setDescription('List issues available on system')
            ->addArgument('user', InputArgument::OPTIONAL, 'Filter user', 'me')
            ->addArgument('project', InputArgument::OPTIONAL, 'Filter project', 'all')
            ->addArgument('status', InputArgument::OPTIONAL, 'Filter status', false)
            ->addOption('limit', '-l', InputOption::VALUE_OPTIONAL, 'Limit results', 25);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArguments();
        $arguments['limit'] = $input->getOption('limit');
        $issues = $this->issuesFactory->getIssues($arguments);

        if (isset($issues['issues'])) {

            $tableIssues = [];

            foreach ($issues['issues'] as $key => $issue) {
                // new table layout
                $estimate = '';

                if (isset($issue['estimated_hours'])) {
                    $estimate = str_pad($issue['estimated_hours'], 4, ' ', STR_PAD_LEFT) . 'h';
                }

                $projectId = str_pad($issue['project']['id'], 3, ' ', STR_PAD_LEFT);

                $tableIssues[$key] = [
                    'id' => "<comment>{$issue['id']}</comment>",
                    'project' => "[{$projectId}] " . substr($issue['project']['name'], 0, 10),
                    'name' => substr($issue['subject'], 0, 40),
                    'status' => substr($issue['status']['name'], 0, 8),
                    'est.' => $estimate,
                ];
            }

            if (!empty($tableIssues)) {
                $table = new Table($output);
                $table
                    ->setHeaders(array_keys($tableIssues['0']))
                    ->setRows($tableIssues);
                $table->render();
            }

            if ($issues['total_count'] == 0) {
                $output->writeln('No issues found: <comment>' . json_encode($arguments) . '</comment>');
            }
        }

        if (isset($issues['0']) && $issues['0'] == false) {
            $output->writeln('No issues found: <comment>' . json_encode($arguments) . '</comment>');
        }
    }
}
