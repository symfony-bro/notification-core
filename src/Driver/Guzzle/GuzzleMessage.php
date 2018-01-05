<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\Guzzle;


use Psr\Http\Message\RequestInterface;
use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

class GuzzleMessage extends AbstractMessage
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(NotificationInterface $notification, RequestInterface $request)
    {
        parent::__construct($notification);
        $this->request = $request;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}