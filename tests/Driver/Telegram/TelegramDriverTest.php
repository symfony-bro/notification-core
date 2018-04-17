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
        /** @var NotificationInterface $notification */
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $message = new TelegramMessage($notification, 'sendMessage');
        $message->setMessage([
            'text' => 'roses are red violets are blue '.(new \DateTime())->format('d.m.Y H:i:s'),
            'parse_mode' => 'HTML',
            'chat_id' => '15967042',
        ]);

        $client = new TelegramClient('346041864:AAGFDQYhEWtEqsmqAOnswHxZ4_zOcJTTn04', [
            'proxy' => 'socks5h://gs:gs@195.123.226.65:28888',
        ]);
        $driver = new TelegramDriver($client);

        $driver->send($message);
        $this->assertTrue(true);
    }
}
