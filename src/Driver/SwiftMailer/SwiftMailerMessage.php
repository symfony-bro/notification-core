<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\SwiftMailer;


use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use Swift_Message;

class SwiftMailerMessage extends AbstractMessage
{
    /**
     * @var Swift_Message
     */
    private $swiftMessage;

    public function __construct(NotificationInterface $notification, Swift_Message $swiftMessage)
    {
        parent::__construct($notification);
        $this->swiftMessage = $swiftMessage;
    }

    /**
     * @return Swift_Message
     */
    public function getSwiftMessage(): Swift_Message
    {
        return $this->swiftMessage;
    }
}
