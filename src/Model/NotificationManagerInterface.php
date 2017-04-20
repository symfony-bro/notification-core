<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


use SymfonyBro\NotificationCore\Exception\NotificationException;

interface NotificationManagerInterface
{
    /**
     * @param NotificationInterface $notification
     * @return void
     * @throws NotificationException
     */
    public function notify(NotificationInterface $notification);
}