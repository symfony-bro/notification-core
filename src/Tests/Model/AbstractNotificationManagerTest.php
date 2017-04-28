<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Tests\Model;


use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Model\AbstractNotificationManager;
use SymfonyBro\NotificationCore\Model\DriverInterface;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class AbstractNotificationManagerTest extends TestCase
{
    public function testNotify()
    {
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        /** @var AbstractNotificationManager|\PHPUnit_Framework_MockObject_MockObject $manager */
        $manager = $this->getMockBuilder(AbstractNotificationManager::class)
            ->setMethods(['beforeFormat', 'createFormatters', 'createDriver', 'beforeSend'])
            ->getMockForAbstractClass()
        ;

        $manager->expects($this->once())
            ->method('beforeFormat')
            ->with($notification)
        ;

        $message1 = $this->getMockForAbstractClass(MessageInterface::class);
        $message2 = $this->getMockForAbstractClass(MessageInterface::class);
        $formatters = [
            $this->createFormatter($notification, $message1),
            $this->createFormatter($notification, $message2),
        ];

        $manager->expects($this->once())
            ->method('createFormatters')
            ->with($notification)
            ->willReturn($formatters)
        ;

        $driver1 = $this->createDriver($message1);
        $driver2 = $this->createDriver($message2);
        $manager->expects($this->exactly(count($formatters)))
            ->method('createDriver')
            ->withConsecutive($message1, $message2)
            ->willReturnOnConsecutiveCalls($driver1, $driver2)
        ;

        $manager->expects($this->exactly(count($formatters)))
            ->method('beforeSend')
            ->withConsecutive($message1, $message2)
        ;

        $manager->notify($notification);
    }

    private function createFormatter($notification, $message)
    {
        $formatter = $this->getMockForAbstractClass(FormatterInterface::class);
        $formatter->expects($this->once())
            ->method('format')
            ->with($notification)
            ->willReturn($message)
        ;
        return $formatter;
    }

    private function createDriver($message)
    {
        $driver = $this->getMockForAbstractClass(DriverInterface::class);
        $driver->expects($this->once())
            ->method('send')
            ->with($message)
        ;
        return $driver;
    }

}