<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Firebase;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SymfonyBro\NotificationCore\Driver\Firebase\FirebaseMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class FirebaseMessageTest extends TestCase
{
    /**
     * @var NotificationInterface
     */
    private $notification;

    public function setUp()
    {
        $this->notification = $this->getMockForAbstractClass(NotificationInterface::class);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRequired()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'title',
            'body'
        );

        $message->asArray();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetEmptyToken()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'title',
            'body'
        );
        $message->setToken('');
    }

    public function testMessageWithToken()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'Lol',
            'Kek cheboorek'
        );

        $message->setToken('device-token');
        $this->assertEquals(
            [
                'message' => [
                    'notification' => [
                        'body' => 'Kek cheboorek',
                        'title' => 'Lol',
                    ],
                    'token' => 'device-token'
                ]
            ],
            $message->asArray()
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetEmptyTopic()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'title',
            'body'
        );
        $message->setTopic('');
    }

    public function testMessageWithTopic()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'Check out this sale!',
            'All items half off through Friday'
        );

        $message->setTopic('sale-watchers');
        $this->assertEquals(
            [
                'message' => [
                    'notification' => [
                        'body' => 'All items half off through Friday',
                        'title' => 'Check out this sale!',
                    ],
                    'topic' => 'sale-watchers'
                ]
            ],
            $message->asArray()
        );

    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetEmptyCondition()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'title',
            'body'
        );
        $message->setCondition('');
    }

    public function testMessageWithCondition()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'FCM Message',
            'This is a Firebase Cloud Messaging Topic Message!'
        );

        $message->setCondition('\'dogs\' in topics || \'cats\' in topics');
        $this->assertEquals(
            [
                'message' => [
                    'notification' => [
                        'body' => 'This is a Firebase Cloud Messaging Topic Message!',
                        'title' => 'FCM Message',
                    ],
                    'condition' => '\'dogs\' in topics || \'cats\' in topics'
                ]
            ],
            $message->asArray()
        );
    }

    public function testMessageWithData()
    {
        $message = new FirebaseMessage(
            $this->notification,
            'title',
            'body'
        );

        $message->setCondition('condition');
        $message->setData(['foo' => 'bar']);

        $this->assertEquals(
            [
                'message' => [
                    'notification' => [
                        'body' => 'body',
                        'title' => 'title',
                    ],
                    'condition' => 'condition',
                    'data' => ['foo' => 'bar'],
                ]
            ],
            $message->asArray()
        );
    }
}
