<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use RootIndex\Redmine\Lite\ListUsers;

class ListUsersCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('users')
            ->setDescription('List users available on system')
            ->addArgument(
                'filter',
                InputArgument::OPTIONAL,
                'Filter users'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filter = $input->getArgument('filter');

        $usersFactory = new ListUsers;
        $users = $usersFactory->getUsers($filter);

        if (isset($users['users'])) {
            $tableUsers = [];

            foreach ($users['users'] as $key => $user) {
                // new table layout
                $tableUsers[$key] = [
                    'id' => "<comment>{$user['id']}</comment>",
                    'login' => $user['login'],
                    'name' => $user['firstname'] . ' ' . $user['lastname'],
                    'email' => $user['mail'],
                ];
            }
        }
        $users = $tableUsers;

        if (!empty($users)) {
            $table = new Table($output);
            $table
                ->setHeaders(array_keys($users['0']))
                ->setRows($users);
            $table->render();
        }
    }
}