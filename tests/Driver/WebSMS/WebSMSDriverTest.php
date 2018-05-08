<?php
/**
 * @author Anikeev Dmitry <dm.anikeev@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\WebSMS;

use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\WebSMS\WebSMSClient;
use SymfonyBro\NotificationCore\Driver\WebSMS\WebSMSDriver;
use SymfonyBro\NotificationCore\Driver\WebSMS\WebSMSMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class WebSMSDriverTest extends TestCase
{
    public function testSend()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new WebSMSMessage($notification, ['+11111111111'], 'test');

        $client = $this->getMockBuilder(WebSMSClient::class)
            ->setConstructorArgs([[
                'login' => 'login',
                'password' => 'password',
                'test' => true,
                'endpoint' => 'http://cab.websms.ru/xml_in5.asp'
            ]])
            ->getMock();
        $client->expects($this->once())
            ->method('call')
            ->with(['+11111111111'], 'test')
            ->willReturn(['ok' => true]);

        $driver = new WebSMSDriver($client);

        $driver->send($message);
    }
}