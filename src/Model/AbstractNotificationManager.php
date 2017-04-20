<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


abstract class AbstractNotificationManager implements NotificationManagerInterface
{
    /**
     * @param NotificationInterface $notification
     */
    public function notify(NotificationInterface $notification)
    {
        $driver = $this->createDriver($notification);

        $this->beforeFormat($notification);
        $formatter = $this->createFormatter($notification);

        $message = $formatter->format($notification);

        $this->beforeSend($message);
        $driver->send($message);
    }

    abstract protected function createDriver(NotificationInterface $notification): DriverInterface;

    abstract protected function createFormatter(NotificationInterface $notification): FormatterInterface;

    protected function beforeFormat(NotificationInterface $notification) {}

    protected function beforeSend(MessageInterface $message) {}

}