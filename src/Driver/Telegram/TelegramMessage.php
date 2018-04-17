<?php

namespace SymfonyBro\NotificationCore\Driver\Telegram;

use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class TelegramMessage extends AbstractMessage
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $message;

    /**
     * TelegramMessage constructor.
     * @param NotificationInterface $notification
     * @param string $method
     */
    public function __construct(NotificationInterface $notification, string $method = 'sendMessage')
    {
        parent::__construct($notification);
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @param array $message
     * @return TelegramMessage
     */
    public function setMessage(array $message = []): TelegramMessage
    {
        $this->message = $message;
        return $this;
    }
}
