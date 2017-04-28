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
}
