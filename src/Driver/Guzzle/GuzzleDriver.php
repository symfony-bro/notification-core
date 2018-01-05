<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\Guzzle;


use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

abstract class GuzzleDriver extends AbstractDriver
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * GuzzleDriver constructor.
     */
    public function __construct()
    {
        $this->client = $this->createClient();
    }

    /**
     * @param MessageInterface $message
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doSend(MessageInterface $message)
    {
        if (!$message instanceof GuzzleMessage) {
            throw new InvalidArgumentException('GuzzleMesage expected, given '.\get_class($message));
        }


        $this->client->send($message->getRequest());
    }

    abstract protected function createClient(): ClientInterface;
}