<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\Guzzle;


use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use SymfonyBro\NotificationCore\Model\AbstractDriver;
use SymfonyBro\NotificationCore\Model\MessageInterface;
use Throwable;

abstract class GuzzleDriver extends AbstractDriver
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * GuzzleDriver constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param MessageInterface $message
     * @throws InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doSend(MessageInterface $message)
    {
        if (!$message instanceof GuzzleMessage) {
            throw new InvalidArgumentException('GuzzleMessage expected, given '.\get_class($message));
        }

        try {
            $response = $this->client->send($message->getRequest(), ['http_errors' => false]);
            $this->handleResponse($response, $message);
        } catch (Throwable $e) {
            $this->handleException($e, $message);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return void
     */
    abstract protected function handleResponse(ResponseInterface $response, MessageInterface $message);

    /**
     * @param Throwable $exception
     * @param GuzzleMessage $message
     * @return void
     */
    abstract protected function handleException(Throwable $exception, GuzzleMessage $message);
}