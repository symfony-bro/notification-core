<?php

namespace SymfonyBro\NotificationCore\Model;

/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
abstract class AbstractMessage implements MessageInterface
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    /**
     * @var mixed
     */
    private $result;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }
}
