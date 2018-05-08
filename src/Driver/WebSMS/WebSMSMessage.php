<?php
/**
 * @author Anikeev Dmitry <dm.anikeev@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\WebSMS;


use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

/**
 * Class WebSMSMessage
 * @package SymfonyBro\NotificationCore\Driver\WebSMS
 */
class WebSMSMessage extends AbstractMessage
{
    /**
     * @var array
     */
    private $recipients;

    /**
     * @var string
     */
    private $body;

    public function __construct(NotificationInterface $notification, array $recipients, string $body)
    {
        parent::__construct($notification);
        $this->recipients = $recipients;
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     * @return WebSMSMessage
     */
    public function setRecipients(array $recipients): WebSMSMessage
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return WebSMSMessage
     */
    public function setBody(string $body): WebSMSMessage
    {
        $this->body = $body;

        return $this;
    }
}