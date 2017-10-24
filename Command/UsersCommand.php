<?php

namespace DZunke\SlackBundle\Command;

use DZunke\SlackBundle\Slack\Users;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UsersCommand extends Command
{
    /**
     * @var Users
     */
    private $api;

    public function __construct(Users $users)
    {
        $this->api = $users;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dzunke:slack:users')
            ->setAliases(['slack:users'])
            ->setDescription('work with the users of your team')
            ->addOption('only-active', 'a', InputOption::VALUE_NONE, 'lists only active users')
            ->addOption('only-deleted', 'd', InputOption::VALUE_NONE, 'lists only deleted users')
            ->addOption('user', 'u', InputOption::VALUE_REQUIRED, 'get a single user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');

        try {
            if ($input->getOption('only-active')) {
                $response = $this->api->getActiveUsers();
            } elseif ($input->getOption('only-deleted')) {
                $response = $this->api->getDeletedUsers();
            } elseif ($input->getOption('user')) {
                $response = $this->api->getUser($input->getOption('user'));

                if (is_array($response)) {
                    $response = [$response['name'] => $response];
                }
            } else {
                $response = $this->api->getUsers();
            }

            if (empty($response)) {
                $output->writeln($formatter->formatBlock('✘ no data found', 'error'));
                return;
            }

            array_walk(
                $response,
                function (&$row) {
                    foreach ($row as &$col) {
                        if (is_bool($col)) {
                            $col = $col ? 'true' : 'false';
                        }
                    }
                }
            );

            $table = new Table($output);
            $table->setHeaders(array_keys(reset($response)))->setRows($response);
            $table->render($output);

        } catch (\Exception $e) {
            $output->writeln(
                $formatter->formatBlock(
                    sprintf('✘ there was an error with your request: "%s"', $e->getMessage()),
                    'error'
                )
            );
        }
    }
}
