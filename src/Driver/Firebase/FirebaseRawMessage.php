<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;


use SymfonyBro\NotificationCore\Model\NotificationInterface;

class FirebaseRawMessage extends AbstractFirebaseMessage
{
    /**
     * @var array
     */
    private $message;

    public function __construct(NotificationInterface $notification, array $message)
    {
        parent::__construct($notification);
        $this->message = $message;
    }

    public function asArray(): array
    {
        return ['message' => $this->message];
    }
}