<?php
/**
 * @author Anikeev Dmitry <dm.anikeev@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\WebSMS;


use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;

/**
 * Class WebSMSDriver
 * @package SymfonyBro\NotificationCore\Driver\WebSMS
 */
class WebSMSDriver extends AbstractDriver
{
    private $client;

    public function __construct(WebSMSClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface|WebSMSMessage $message
     */
    protected function doSend(MessageInterface $message)
    {
        $this->client->call($message->getRecipients(), $message->getBody());
    }
}