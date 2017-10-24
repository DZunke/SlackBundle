<?php

namespace DZunke\SlackBundle\Command;

use DZunke\SlackBundle\Slack\Messaging;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessageCommand extends Command
{
    private $messenger;

    public function __construct(Messaging $messenger)
    {
        $this->messenger = $messenger;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dzunke:slack:message')
            ->setAliases(['slack:message'])
            ->setDescription('Sending a Message to a Channel or User')
            ->addArgument('channel', InputArgument::REQUIRED, 'an existing channel in your team to send to')
            ->addArgument('username', InputArgument::REQUIRED, 'an username from configured identities to send with')
            ->addArgument('message', InputArgument::REQUIRED, 'the message to send');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $response = $this->messenger->message(
                $input->getArgument('channel'),
                $input->getArgument('message'),
                $input->getArgument('username')
            );

            if ($response->getStatus() === false) {
                $output->writeln('<error>✘ request got an error from slack: "' . $response->getError() . '"</error>');
                return;
            }

            $output->writeln('<info>✔ message was sent to ' . $input->getArgument('channel') . '</info>');
        } catch (\Exception $e) {
            $output->writeln('<error>✘ there was an error while sending message: "' . $e->getMessage() . '"</error>');
        }
    }
}
