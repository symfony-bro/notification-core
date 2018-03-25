<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Guzzle;


use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Guzzle\GuzzleDriver;
use SymfonyBro\NotificationCore\Driver\Guzzle\GuzzleMessage;
use SymfonyBro\NotificationCore\Exception\NotificationException;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class GuzzleDriverTest extends TestCase
{
    public function testSend()
    {
        $request = new Request('POST', '/pp]');
        $response = new Response();

        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        $message = new GuzzleMessage($notification, $request);

        $client = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['send'])
            ->getMockForAbstractClass()
        ;
        $client->expects($this->once())
            ->method('send')
            ->with($request)
            ->willReturn($response)
        ;

        /** @var MockObject|GuzzleDriver $driver */
        $driver = $this->getMockBuilder(GuzzleDriver::class)
            ->setConstructorArgs([$client])
            ->getMockForAbstractClass()
        ;

        $driver->expects($this->once())
            ->method('handleResponse')
            ->with($response, $message);

        $driver->send($message);
    }

    public function testSendClientException()
    {
        $request = new Request('POST', '/pp]');
        $exception = new Exception('Client exception');

        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        $message = new GuzzleMessage($notification, $request);

        $client = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['send'])
            ->getMockForAbstractClass()
        ;
        $client->expects($this->once())
            ->method('send')
            ->with($request)
            ->willThrowException($exception)
        ;

        /** @var MockObject|GuzzleDriver $driver */
        $driver = $this->getMockBuilder(GuzzleDriver::class)
            ->setConstructorArgs([$client])
            ->getMockForAbstractClass()
        ;

        $driver->expects($this->once())
            ->method('handleException')
            ->with($exception, $message);

        $driver->send($message);
    }

    public function testSendWithWrongMessageType()
    {
        $message = $this->getMockForAbstractClass(MessageInterface::class);

        /** @var MockObject|GuzzleDriver $driver */
        $driver = $this->getMockBuilder(GuzzleDriver::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $this->expectException(NotificationException::class);
        $driver->send($message);
    }
}