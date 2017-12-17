<?php

namespace SymfonyBro\NotificationCore\Tests\Model;

use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Model\AbstractNotificator;
use SymfonyBro\NotificationCore\Model\ContextInterface;
use SymfonyBro\NotificationCore\Model\NotificationBuilderInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use SymfonyBro\NotificationCore\Model\NotificationManagerInterface;
use SymfonyBro\NotificationCore\Model\RecipientFinderInterface;
use SymfonyBro\NotificationCore\Model\RecipientInterface;
use SymfonyBro\NotificationCore\Model\TemplateFinderInterface;
use SymfonyBro\NotificationCore\Model\TemplateInterface;

class AbstractNotificatorTest extends TestCase
{

    public function testNotify()
    {
        $context = new class implements ContextInterface {};

        $recipientFinder = $this->getMockForAbstractClass(RecipientFinderInterface::class);

        $templateFinder = $this->getMockForAbstractClass(TemplateFinderInterface::class);

        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        $builder = $this->getMockForAbstractClass(NotificationBuilderInterface::class);

        $manager = $this->getMockForAbstractClass(NotificationManagerInterface::class);

        $recipients = [
            $this->getMockForAbstractClass(RecipientInterface::class),
            $this->getMockForAbstractClass(RecipientInterface::class),
        ];

        $templates = [
            $this->getMockForAbstractClass(TemplateInterface::class),
            $this->getMockForAbstractClass(TemplateInterface::class),
        ];

        $recipientFinder->expects($this->once())
            ->method('find')
            ->with($context)
            ->willReturn($recipients);

        $templateFinder->expects($this->once())
            ->method('find')
            ->with($context)
            ->willReturn($templates);

        $builder->expects($this->exactly(count($recipients) * count($templates)))
            ->method('build')
            ->willReturn($notification);

        $manager->expects($this->exactly(count($recipients) * count($templates)))
            ->method('notify')
            ->with($notification);

        $notifier = new class($recipientFinder, $templateFinder, $builder, $manager) extends AbstractNotificator {

        };

        $notifier->notify($context);
    }
}
