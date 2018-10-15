<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;


use InvalidArgumentException;
use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

class FirebaseDriver extends AbstractDriver
{
    /**
     * @var string
     */
    private $project;

    /**
     * @var ClientBuilderInterface
     */
    private $builder;

    public function __construct(ClientBuilderInterface $builder, string $project)
    {
        $this->project = $project;
        $this->builder = $builder;
    }

    /**
     * @param MessageInterface $message
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doSend(MessageInterface $message)
    {
        if (!$message instanceof AbstractFirebaseMessage) {
            throw new InvalidArgumentException('Instance of AbstractFirebaseMessage expected, given '.\get_class($message));
        }

        $this
            ->builder
            ->build()
            ->request(
                'POST',
                "https://fcm.googleapis.com/v1/projects/{$this->project}/messages:send",
                [
                    'json' => $message->asArray(),
                ]
            );
    }
}