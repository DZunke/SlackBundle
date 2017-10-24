<?php

namespace DZunke\SlackBundle\Command;

use DZunke\SlackBundle\Slack\Channels;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeChannelsTopicCommand extends Command
{
    /**
     * @var Channels
     */
    private $channels;

    public function __construct(Channels $channels)
    {
        $this->channels = $channels;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dzunke:slack:channels:topic')
            ->setAliases(['slack:channels:topic'])
            ->setDescription('Changing the Topic of a Channel')
            ->addOption('discover', 'd', InputOption::VALUE_NONE, 'channel name is given, so discover the id')
            ->addArgument('channel', InputArgument::REQUIRED, 'an existing channel in your team to change the topic')
            ->addArgument('topic', InputArgument::REQUIRED, 'the topic you want to set in the channel');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            if ($input->getOption('discover')) {
                $channelId = $this->channels->getId($input->getArgument('channel'));
            } else {
                $channelId = $input->getArgument('channel');
            }

            $response = $this->channels->setTopic(
                $channelId,
                $input->getArgument('topic')
            );

            if ($response->getStatus() === false) {
                $output->writeln('<error>✘ request got an error from slack: "' . $response->getError() . '"</error>');

                return;
            }

            $output->writeln('<info>✔ changed topic</info>');

            if ($output->getVerbosity() == OutputInterface::VERBOSITY_VERBOSE) {
                $output->writeln('<options=bold>Old Topic:</options=bold> ' . $response->getData()['old_topic']);
                $output->writeln('<options=bold>New Topic:</options=bold> ' . $response->getData()['new_topic']);
            }

        } catch (\Exception $e) {
            $output->writeln('<error>✘ there was an error while changing topic: "' . $e->getMessage() . '"</error>');
        }
    }
}
