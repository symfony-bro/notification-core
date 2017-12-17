<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 18.12.17
 * Time: 0:33
 */

namespace SymfonyBro\NotificationCore\Model;


interface NotificationBuilderInterface
{
    public function build(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template): NotificationInterface;
}