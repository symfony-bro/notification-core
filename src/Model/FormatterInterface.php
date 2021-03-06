<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


interface FormatterInterface
{
    /**
     * @param NotificationInterface $notification
     * @return MessageInterface
     */
    public function format(NotificationInterface $notification): MessageInterface;
}
