<?php

namespace DZunke\SlackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UsersCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('dzunke:slack:users')
            ->setDescription('work with the users of your team')
            ->addOption('only-active', 'a', InputOption::VALUE_NONE, 'lists only active users')
            ->addOption('only-deleted', 'd', InputOption::VALUE_NONE, 'lists only deleted users')
            ->addOption('user', 'u', InputOption::VALUE_REQUIRED, 'get a single user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');

        try {
            $api = $this->getContainer()->get('dz.slack.users');

            if ($input->getOption('only-active')) {
                $response = $api->getActiveUsers();
            } elseif ($input->getOption('only-deleted')) {
                $response = $api->getDeletedUsers();
            } elseif ($input->getOption('user')) {
                $response = $api->getUser($input->getOption('user'));

                if (is_array($response)) {
                    $response = [$response['name'] => $response];
                }
            } else {
                $response = $api->getUsers();
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

            $table = $this->getHelper('table');
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
