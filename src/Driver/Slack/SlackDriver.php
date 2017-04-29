<?php

namespace SymfonyBro\NotificationCore\Driver\Slack;

use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

/**
 * Class SlackDriver
 *
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class SlackDriver extends AbstractDriver
{
    /**
     * @var SlackClient
     */
    private $client;

    /**
     * SlackDriver constructor.
     * @param SlackClient $client
     */
    public function __construct(SlackClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface|SlackMessage $message
     * @throws \InvalidArgumentException
     */
    protected function doSend(MessageInterface $message)
    {
        $result = $this->client->call($message->getMethod(), $message->getMessage());
        if (!$result['ok']) {
            throw new \InvalidArgumentException($result['error'] ?? 'Unknown error occurred.');
        }
    }
}
