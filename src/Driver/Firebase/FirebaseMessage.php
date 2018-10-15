<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;


use SymfonyBro\NotificationCore\Model\NotificationInterface;

class FirebaseMessage extends AbstractFirebaseMessage
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * Token for the specific app instance you want to target
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $topic;

    /**
     * @var string
     */
    private $condition;

    /**
     * @var array
     */
    private $data;

    public function __construct(NotificationInterface $notification, string $title, string $body)
    {
        parent::__construct($notification);
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * @param string $token
     * @return FirebaseMessage
     */
    public function setToken(string $token): FirebaseMessage
    {
        if (empty($token)) {
            throw new \InvalidArgumentException('Value is empty');
        }
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $topic
     * @return FirebaseMessage
     */
    public function setTopic(string $topic): FirebaseMessage
    {
        if (empty($topic)) {
            throw new \InvalidArgumentException('Value is empty');
        }
        $this->topic = $topic;
        return $this;
    }

    /**
     * @param string $condition
     * @return FirebaseMessage
     */
    public function setCondition(string $condition): FirebaseMessage
    {
        if (empty($condition)) {
            throw new \InvalidArgumentException('Value is empty');
        }
        $this->condition = $condition;
        return $this;
    }

    /**
     * @param array $data
     * @return FirebaseMessage
     */
    public function setData(array $data): FirebaseMessage
    {
        $this->data = $data;
        return $this;
    }

    public function asArray(): array
    {
        if (null === $this->token && null === $this->topic && null === $this->condition) {
            throw new \RuntimeException('\'token\' or \'topic\' or \'condition\' must be defined');
        }

        $message = [
            'notification' => [
                'body' => $this->body,
                'title' => $this->title,
            ],
        ];

        if (null !== $this->token) {
            $message['token'] = $this->token;
        } elseif (null !== $this->topic) {
            $message['topic'] = $this->topic;
        } else {
            $message['condition'] = $this->condition;
        }

        if (!empty($this->data)) {
            $message['data'] = $this->data;
        }

        return [
            'message' => $message,
        ];
    }

}