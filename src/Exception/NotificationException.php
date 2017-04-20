<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Exception;


use SymfonyBro\NotificationCore\Model\NotificationInterface;
use Throwable;

class NotificationException extends \Exception
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    public function __construct(NotificationInterface $notification, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
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