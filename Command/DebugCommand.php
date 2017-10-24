<?php

namespace DZunke\SlackBundle\Command;

use DZunke\SlackBundle\Slack\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DebugCommand extends Command
{
    protected static $defaultName = 'slack:debug';

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName(static::$defaultName)
            ->setDescription('Gives some Debug Informations about the SlackBundle');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $config = $this->getContainer()->getParameter('d_zunke_slack.config');

        $this->renderConnection($config);
        $this->output->writeln('');
        $this->renderIdentities($config);
        $this->output->writeln('');
        $this->renderSlackChannels($config);
    }

    protected function renderSlackChannels()
    {
        $this->output->writeln('<info>Available Channels</info>');

        $channels = $this->client->send(
            Client\Actions::ACTION_CHANNELS_LIST,
            [],
            null
        );

        if ($channels->getStatus() === false) {
            $this->output->writeln('<error>' . $channels->getError() . '</error>');

            return;
        }

        $table = new Table($this->output);

        $index = 0;
        foreach ($channels->getData() as $name => $channel) {

            if ($index > 0) {
                $table->addRow(new TableSeparator());
            }

            $table->addRow(['<info>' . $name . '</info>']);
            $table->addRow(
                [
                    '  id',
                    $channel['id']
                ]
            );

            $index++;
        }

        $table->render();
    }

    protected function renderIdentities(array $config)
    {
        $this->output->writeln('<info>Identities</info>');

        $table = new Table($this->output);

        $index = 0;
        foreach ($config['identities'] as $username => $userConfig) {

            if ($index > 0) {
                $table->addRow(new TableSeparator());
            }

            $table->addRow(['<info>' . $username . '</info>']);

            foreach ($userConfig as $configName => $configValue) {
                $table->addRow(
                    [
                        "  " . $configName,
                        is_null($configValue) ? 'null' : $configValue
                    ]
                );
            }

            $index++;
        }

        $table->render();
    }

    protected function renderConnection(array $config)
    {
        $this->output->writeln('<info>Connection</info>');

        $table = new Table($this->output);

        $table->addRow(['endpoint', $config['endpoint']]);
        $table->addRow(['token', $config['token']]);

        $table->addRow(new TableSeparator());
        $table->addRow(['ConnectionStatus', $this->connectionTest()]);
        $table->addRow(['Authorization', $this->authTest()]);

        $table->render();
    }

    protected function connectionTest()
    {
        $connectionTest = $this->client->send(
            Client\Actions::ACTION_API_TEST,
            [],
            null
        );

        if ($connectionTest->getStatus()) {
            $statusMessage = '<info>Ok</info>';
        } else {
            $statusMessage = '<error>' . $connectionTest->getError() . '</error>';
        }

        return $statusMessage;
    }

    protected function authTest()
    {
        $authTest = $this->client->send(
            Client\Actions::ACTION_AUTH_TEST,
            [],
            null
        );

        if ($authTest->getStatus()) {
            $statusMessage = '<info>Ok - User: ' . $authTest->getData()['user'] . '</info>';
        } else {
            $statusMessage = '<error>' . $authTest->getError() . '</error>';
        }

        return $statusMessage;
    }

}
