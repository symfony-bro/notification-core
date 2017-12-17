<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


interface SenderInterface
{
    public function send(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template);
}