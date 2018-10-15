<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Firebase;

use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Firebase\FirebaseRawMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class FirebaseRawMessageTest extends TestCase
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    public function setUp()
    {
        $this->notification = $this->getMockForAbstractClass(NotificationInterface::class);
    }

    public function testAsArray()
    {
        $message = new FirebaseRawMessage(
            $this->notification, [
                'topic' =>'sale-watchers',
                'notification' => [
                    'title' =>'Check out this sale!',
                    'body' =>'All items half off through Friday'
                ],
                'android' =>[
                    'notification' => [
                        'click_action' =>'OPEN_ACTIVITY_3'
                    ]
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'category' => 'SALE_CATEGORY'
                        ]
                    ]
                ]
            ]
        );

        $this->assertEquals([
            'message' => [
                'topic' =>'sale-watchers',
                'notification' => [
                    'title' =>'Check out this sale!',
                    'body' =>'All items half off through Friday'
                ],
                'android' =>[
                    'notification' => [
                        'click_action' =>'OPEN_ACTIVITY_3'
                    ]
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'category' => 'SALE_CATEGORY'
                        ]
                    ]
                ]
            ]
        ], $message->asArray());
    }
}

