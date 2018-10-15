<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;


use GuzzleHttp\ClientInterface;

class InMemoryCachedClientBuilder implements ClientBuilderInterface
{
    /**
     * @var ClientBuilderInterface
     */
    private $origin;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientBuilderInterface $origin)
    {
        $this->origin = $origin;
    }

    public function build(): ClientInterface
    {
        if (null === $this->client) {
            $this->client = $this->origin->build();
        }

        return $this->client;
    }
}