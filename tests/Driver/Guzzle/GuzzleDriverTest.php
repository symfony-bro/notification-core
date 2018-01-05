<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Guzzle;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Guzzle\GuzzleDriver;
use SymfonyBro\NotificationCore\Driver\Guzzle\GuzzleMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class GuzzleDriverTest extends TestCase
{
    public function testSend()
    {
        $request = new Request('POST', '/resource');
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        $message = new GuzzleMessage($notification, $request);

        $client = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['send'])
            ->getMockForAbstractClass()
        ;
        $client->expects($this->once())
            ->method('send');

        /** @var MockObject|GuzzleDriver $driver */
        $driver = $this->getMockBuilder(GuzzleDriver::class)
            ->setMethods([])
            ->getMockForAbstractClass()
        ;


        $driver->send($message);
    }
}