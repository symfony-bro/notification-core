<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;


use Exception;

abstract class AbstractNotificationManager implements NotificationManagerInterface
{
    /**
     * @param NotificationInterface $notification
     */
    public function notify(NotificationInterface $notification)
    {
        $this->beforeFormat($notification);
        $formatters = $this->createFormatters($notification);
        foreach ($formatters as $formatter) {
            try {
                $message = $formatter->format($notification);
            } catch (Exception $exception) {
                $this->onFormatException($notification, $exception);
            }

            try {
                $driver = $this->createDriver($message);
            } catch (Exception $exception) {
                $this->onDriverCreateException($notification, $message, $exception);
            }

            try {
                $this->beforeSend($message);
                $driver->send($message);
            } catch (Exception $exception) {
                $this->onSendException($notification, $message, $exception);
            }
        }
    }

    abstract protected function createDriver(MessageInterface $message): DriverInterface;

    /**
     * @param NotificationInterface $notification
     * @return FormatterInterface[]
     */
    abstract protected function createFormatters(NotificationInterface $notification): array;

    protected function beforeFormat(NotificationInterface $notification) {}

    protected function beforeSend(MessageInterface $message) {}

    protected function onFormatException(NotificationInterface $notification, Exception $exception) {}

    protected function onDriverCreateException(NotificationInterface $notification, MessageInterface $message, Exception $exception) {}

    protected function onSendException(NotificationInterface $notification, MessageInterface $message, Exception $exception) {}

}