<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


interface RecipientFinderInterface
{
    /**
     * @param ContextInterface $context
     * @return RecipientInterface[]
     */
    public function find(ContextInterface $context): array;
}