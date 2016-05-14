<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            ->addArgument(
                'user',
                InputArgument::OPTIONAL,
                'Filter user',
                false
            )
            ->addArgument(
                'project',
                InputArgument::OPTIONAL,
                'Filter project',
                false
            )
            ->addArgument(
                'status',
                InputArgument::OPTIONAL,
                'Filter status',
                false
            )
            ->addArgument(
                'tracker',
                InputArgument::OPTIONAL,
                'Filter status',
                false
            )
            ->addArgument(
                'limit',
                InputArgument::OPTIONAL,
                'Limit results',
                25
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arguments = $input->getArguments();

        $issues = $this->issuesFactory->getIssues($arguments);

        if (isset($issues['issues'])) {
            $tableIssues = [];
            foreach ($issues['issues'] as $key => $issue) {
                // new table layout
                $tableIssues[$key] = [
                    'id' => "<comment>{$issue['id']}</comment>",
                    'name' => $issue['subject'],
                ];
            }
            if (!empty($tableIssues)) {
                $table = new Table($output);
                $table
                    ->setHeaders(array_keys($tableIssues['0']))
                    ->setRows($tableIssues);
                $table->render();
            }
        }
    }
}
