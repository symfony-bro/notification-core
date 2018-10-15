<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Firebase;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Firebase\ClientBuilder;

class ClientBuilderTest extends TestCase
{
    public function testBuild()
    {
        $this->expectException(ClientException::class);
        $builder = new ClientBuilder(__DIR__.'/conf.json');
        $builder->build()
            ->request(
                'POST',
                "https://fcm.googleapis.com/v1/projects/test/messages:send",
                [
                    'json' => [],
                ]
            );

    }
}
