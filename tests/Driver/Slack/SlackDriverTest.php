<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Slack;

use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Slack\SlackClient;
use SymfonyBro\NotificationCore\Driver\Slack\SlackDriver;
use SymfonyBro\NotificationCore\Driver\Slack\SlackMessage;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class SlackDriverTest extends TestCase
{
    public function testSendWithOutResult()
    {
        $client = new SlackClient('token');
        $driver = new SlackDriver($client);
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new SlackMessage($notification, 'token');

        $this->expectException(NotificationException::class);
        $driver->send($message);
    }

    public function testSendWithErrorResult()
    {
        $client = $this->getMockBuilder(SlackClient::class)
            ->getMock();
        $client->method('call')
            ->willReturn(['ok'=>false]);

        $driver = new SlackDriver($client);
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new SlackMessage($notification, 'token');

        $this->expectException(NotificationException::class);
        $driver->send($message);
    }

    public function testSend()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new SlackMessage($notification, 'token', 'chat.postMessage');

        $client = $this->getMockBuilder(SlackClient::class)
            ->getMock();
        $client->expects($this->once())
            ->method('call')
            ->with('chat.postMessage', $message->getMessage())
            ->willReturn(['ok'=>true]);

        $driver = new SlackDriver($client);

        $driver->send($message);

    }
}
