<?php
namespace SymfonyBro\NotificationCore\Driver\Telegram;


use InvalidArgumentException;
use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class TelegramDriver extends AbstractDriver
{
    /**
     * @var TelegramClient
     */
    private $client;

    /**
     * TelegramDriver constructor.
     * @param TelegramClient $client
     */
    public function __construct(TelegramClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface|TelegramMessage $message
     * @throws InvalidArgumentException
     */
    protected function doSend(MessageInterface $message)
    {
        $result = $this->client->call($message->getMethod(), $message->getMessage());
        if (!$result['ok']) {
            throw new InvalidArgumentException($result['error'] ?? 'Unknown error occurred.');
        }
    }
}
