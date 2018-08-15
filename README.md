# Introduction
This library is provided to abstract transport layer of notification process. 
# Architecture
## Transport layer
The main abstraction of the transport layer is 
`\SymfonyBro\NotificationCore\Model\NotificationManagerInterface` 
with only method `notify(NotificationInterface $notification)`.
The idea is that we should create a notification object for some event and send it
with notification manager. So, client code knows nothing about how notification will be send.

We've created an abstract implementation for this interface &mdash;
`\SymfonyBro\NotificationCore\Model\AbstractNotificationManager`.
Internally it delegates job to formatter and driver objects.
### Driver
Driver object implements `\SymfonyBro\NotificationCore\Model\DriverInterface`
and responsible for sending a message. Message is another object implements
`\SymfonyBro\NotificationCore\Model\MessageInterface` related to a specific driver.
For example we have SwiftMailerDriver out of the box and it can send SwiftMailerMessage.
But where do we get a message object?
### Formatter
There is formatter object which implements `\SymfonyBro\NotificationCore\Model\FormatterInterface`.
The only purpose of formatter is creating a message object from a notification object.
### Examples
Say, we have to send an email to the client if he makes new order. 
Suppose you already have some observer pattern implementation 
and you have listener for new order event.
First we should create new notification class for this event:
```php
<?php

use SymfonyBro\NotificationCore\Model\NotificationInterface;
use App\Model\Order;

class OrderCreatedNotification implements NotificationInterface
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}
```
It should contains all required information, in example above it receives an 
`Order` object and we suppose that `Order` contains `Customer` object 
with some kind of contact information: `$order->getCustomer()->getEmail()`.

Then we have to create a formatter object:
```php
<?php
namespace App\Notifications\Order;

use App\Model\Order;
use SymfonyBro\NotificationCore\Driver\SwiftMailer\SwiftMailerMessage;
use SymfonyBro\NotificationCore\Model\FormatterInterface;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use SymfonyBro\NotificationCore\Model\NotificationInterface;
use Swift_Message;

class OrderCreatedEmailFormatter implements FormatterInterface
{
    /**
     * @param NotificationInterface $notification
     * @return MessageInterface|OrderCreatedNotification
     */
    public function format(NotificationInterface $notification): MessageInterface
    {
        $customer = $notification->getOrder()->getCustomer();
        return new SwiftMailerMessage(
            $notification,
            (new Swift_Message('New order #'. $customer->getId()))
                ->setFrom(['noreply@acme-shop.com' => 'ACME SHOP LTD.'])
                ->setTo([
                    $customer->getEmail() => $customer->getName(),
                ])
                ->setBody('you can render content using some templating engine')
        );
    }
}
```
