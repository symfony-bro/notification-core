<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


interface TemplateFinderInterface
{
    /**
     * @param ContextInterface $context
     * @return TemplateInterface[]
     */
    public function find(ContextInterface $context): array;
}