<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;

use Google_Client;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;

class ClientBuilder implements ClientBuilderInterface
{
    /**
     * @var string
     */
    private $config;

    public function __construct(string $config)
    {
        $this->config = $config;
    }

    public function build(): ClientInterface
    {
        $client = new Google_Client();
        $client->setAuthConfig($this->config);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        return $client->authorize(
            new Client(
                [
                    'handlers' => HandlerStack::create()
                ]
            )
        );
    }
}