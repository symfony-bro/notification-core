<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;


use SymfonyBro\NotificationCore\Model\AbstractMessage;

abstract class AbstractFirebaseMessage extends AbstractMessage
{
    abstract public function asArray(): array;
}