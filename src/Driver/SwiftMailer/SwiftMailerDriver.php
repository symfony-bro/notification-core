<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\SwiftMailer;

use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

class SwiftMailerDriver extends AbstractDriver
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * SwiftMailerDriver constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param MessageInterface|SwiftMailerMessage $message
     */
    protected function doSend(MessageInterface $message)
    {
        $this->mailer->send($message->getSwiftMessage());
    }
}
