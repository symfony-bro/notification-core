<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;

/**
 * Interface MessageInterface Object accepted by
 * @package SymfonyBro\NotificationCore\Model
 */
interface MessageInterface
{
    public function getNotification(): NotificationInterface;

    /**
     * @param mixed $result
     */
    public function setResult($result);

    /**
     * @return mixed
     */
    public function getResult();
}