<?php
/**
 * Copyright (c) 2016 Francois Raubenheimer.
 */

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use RootIndex\Redmine\Lite\ListProjects;

class ListProjectsCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('projects')
            ->setDescription('List projects available on system')
            ->addOption("limit", 'l', InputOption::VALUE_OPTIONAL, 'Limit results', 100)
            ->addOption("trackers", 't', InputOption::VALUE_OPTIONAL, 'Show trackers', 'false')
            ->addArgument('filter', InputArgument::OPTIONAL, 'Filter identifiers or project names', '');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit = (int)$input->getOption('limit');
        $showTrackers = (string)$input->getOption('trackers');
        $filter = strtolower((string)$input->getArgument('filter'));

        $projectsFactory = new ListProjects;
        $projects = $projectsFactory->getProjects($limit);

        if (isset($projects['projects'])) {
            $tableProjects = [];
            $newKey = 0;
            foreach ($projects['projects'] as $project) {
                if (isset($filter) && $filter != '') {
                    // search projects @dirty
                    if (!preg_match("/$filter/", strtolower($project['name']))
                        && !preg_match("/$filter/", strtolower($project['identifier']))) {
                        continue;
                    }
                }
                // new table layout
                $tableProjects[$newKey] = [
                    'id' => "<comment>{$project['id']}</comment>",
                    'identifier' => $project['identifier'],
                    'name' => $project['name'],
                ];

                if (isset($project['parent'])) {
                    $tableProjects[$newKey]['name'] = "{$tableProjects[$newKey]['name']} "
                        ."[<info>{$project['parent']['name']}</info>]";
                }

                if ($showTrackers != 'false') {
                    $trackers = [];
                    foreach ($project['trackers'] as $tracker) {
                        $trackers[] = $tracker['id'] . ':' . "<comment>{$tracker['name']}</comment>";
                    }
                    if (!empty($trackers)) {
                        $tableProjects[$newKey]['trackers'] = implode("\n", $trackers);
                    }
                }
                $newKey++;
            }


            if (count($tableProjects)) {
                $table = new Table($output);
                $table
                    ->setHeaders(array_keys($tableProjects['0']))
                    ->setRows($tableProjects);
                $table->render();
            }
        }

        if (empty($projects)) {
            $output->writeln('No projects found with the specified search criteria');
        }
    }
}
