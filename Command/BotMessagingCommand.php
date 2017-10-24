<?php

namespace DZunke\SlackBundle\Command;

use DZunke\SlackBundle\Event;
use DZunke\SlackBundle\Events;
use DZunke\SlackBundle\Slack\Channels;
use DZunke\SlackBundle\Slack\Client;
use DZunke\SlackBundle\Slack\Entity\Message;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BotMessagingCommand extends Command
{
    const PROCESS_ITERATION_SLEEP = 1;

    protected static $defaultName = 'slack:run-bot';    

    /**
     * @var Channels
     */
    private $channels;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(Channels $channels, EventDispatcherInterface $eventDispatcher)
    {
        $this->channels = $channels;
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(static::$defaultName)
            ->setDescription('Running the Bot-User to a Channel')
            ->addArgument(
                'channel',
                InputArgument::REQUIRED,
                'Channel to Watch over'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new Logger(new StreamHandler('php://output'));

        $channel = $this->channels->getId($input->getArgument('channel'));
        if (empty($channel)) {
            $logger->error('channel "' . $channel . '" does not exists');
            return;
        }

        $lastTimestamp = time();
        while (true) {
            
            try {
                $latestMessages = $this->channels->history($channel, $lastTimestamp);

                foreach ($latestMessages as $message) {
                    if ($message->isBot() === true) {
                        continue;
                    }

                    $logger->debug('Handling Message of Type : "' .  $message->getType() . '"');

                    $event = Event::MESSAGE;
                    switch ($message->getType()) {
                        case Message::TYPE_MESSAGE :
                            $event = Event::MESSAGE;
                            break;
                        case Message::TYPE_CHANNEL_JOIN:
                            $event = Event::JOIN;
                            break;
                        case Message::TYPE_CHANNEL_LEAVE:
                            $event = Event::LEAVE;
                            break;
                    }

                    $logger->debug('Dispatching "' . $event . '"');

                    $this->eventDispatcher->dispatch(
                        $event,
                        new Events\MessageEvent($channel, $message)
                    );

                    $lastTimestamp = $message->getId();
                }

                $logger->debug('Handled ' . count($latestMessages) . ' Messages');

            } catch (\Exception $e) {
                $logger->error($e->getMessage());
                $logger->error($e->getTraceAsString());
            }

            sleep(self::PROCESS_ITERATION_SLEEP);
        }
    }
}
