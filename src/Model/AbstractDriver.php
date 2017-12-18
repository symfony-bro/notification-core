<?php
namespace SymfonyBro\NotificationCore\Model;

use Exception;
use SymfonyBro\NotificationCore\Exception\NotificationException;

/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * @param MessageInterface $message
     * @return void
     * @throws NotificationException
     */
    public function send(MessageInterface $message)
    {
        try {
            $this->doSend($message);
        } catch (Exception $exception) {
            throw new NotificationException($message->getNotification(), $exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param MessageInterface $message
     */
    abstract protected function doSend(MessageInterface $message);
}
