# Symfony SlackBundle - Full Slack Integration

## Basic-Usage

    $identity = new Identity();
    $identity->setUsername('Testuser');

    $connection = new Connection();
    $connection->setEndpoint('slack.com/api/');
    $connection->setToken('##API-KEY##');

    $client = new Client($connection);
    $client->addIdentity($identity);

    $client->send(Client\Actions::ACTION_POST_MESSAGE, ['channel' => '#slack-testing', 'text' => 'TEST'], 'Testuser');

## License

SlackBundle is licensed under the MIT license.
