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
     * @var string
     */
    private $token;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @var array
     */
    private $message;

    public function __construct(NotificationInterface $notification, string $token, $method = 'getMe', $timeout = 10)
    {
        parent::__construct($notification);
        $this->method = $method;
        $this->timeout = $timeout;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
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
