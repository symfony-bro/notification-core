<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Telegram;

use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Telegram\TelegramClient;
use SymfonyBro\NotificationCore\Driver\Telegram\TelegramDriver;
use SymfonyBro\NotificationCore\Driver\Telegram\TelegramMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class TelegramDriverTest extends TestCase
{
    public function testSend()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new TelegramMessage($notification, 'token', 'getMe');
        $message->setMessage([]);

        $client = $this->getMockBuilder(TelegramClient::class)
            ->getMock();
        $client->expects($this->once())
            ->method('call')
            ->with('token', 'getMe', [])
            ->willReturn(['ok' => true]);

        $driver = new TelegramDriver($client);

        $driver->send($message);
    }
}
