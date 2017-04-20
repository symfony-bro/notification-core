<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


interface DriverInterface
{
    /**
     * @param MessageInterface $message
     * @return void
     */
    public function send(MessageInterface $message);
}