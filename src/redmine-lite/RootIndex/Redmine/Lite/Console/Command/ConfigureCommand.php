<?php

namespace RootIndex\Redmine\Lite\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use RootIndex\Redmine\Lite\ConfigureConfig as Configuration;

/**
 * Class ConfigureCommand
 * @package RootIndex\Redmine\Lite\Console\Command
 */
class ConfigureCommand extends Command
{
    /** @var InputInterface */
    private $input;
    /** @var OutputInterface */
    private $output;
    /** @var string */
    private $redmineUrl;
    /** @var string */
    private $redmineUserToken;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('configure')
            ->setDescription('Configure application');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Running Configuration for {$this->getApplication()->getLongVersion()}");

        $this->input = $input;
        $this->output = $output;

        $redmine = $this->getRedmineUrl();
        $this->output->writeln("Saving <comment>{$this->redmineUrl}</comment> to configuration.");

        $token = $this->getRedmineUserToken();
        $this->output->writeln("Saving <comment>{$this->redmineUserToken}</comment> to configuration.");

        $configuration = new Configuration;
        $configuration->save([
            'server' => $redmine,
            'token' => $token,
        ]);

        $output->writeln('Configuration successful you can now use the app!');
    }

    /**
     * @return string
     */
    public function getRedmineUrl()
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the Redmine URL: ');
        $answer = $helper->ask($this->input, $this->output, $question);
        $this->redmineUrl = trim($answer, '/');

        if ($answer == '' || !filter_var($answer, FILTER_VALIDATE_URL)) {
            $this->output->writeln('Url not valid please correct [http://redmine.org | https://redmine.org:4444]');
            $this->getRedmineUrl();
        }
        return $this->redmineUrl;
    }

    /**
     * @return string
     */
    public function getRedmineUserToken()
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the Redmine Token: ');
        $answer = $helper->ask($this->input, $this->output, $question);
        $this->redmineUserToken = $answer;

        // Md5 hash string length
        if ($answer == ''|| strlen($answer) < 32) {
            $this->output->writeln("Token not valid [Go to {$this->redmineUrl}/my/api_key to get your token]");
            $this->getRedmineUserToken();
        }
        return $this->redmineUserToken;
    }
}
