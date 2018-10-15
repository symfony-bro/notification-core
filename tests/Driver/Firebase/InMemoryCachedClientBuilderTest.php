<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Tests\Driver\Firebase;

use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SymfonyBro\NotificationCore\Driver\Firebase\ClientBuilderInterface;
use SymfonyBro\NotificationCore\Driver\Firebase\InMemoryCachedClientBuilder;

class InMemoryCachedClientBuilderTest extends TestCase
{
    public function testBuild()
    {
        /** @var MockObject|ClientBuilderInterface $origin */
        $origin = $this->getMockForAbstractClass(ClientBuilderInterface::class);
        $origin->expects($this->once())
            ->method('build')
            ->willReturn($client = new Client())
        ;

        $cached = new InMemoryCachedClientBuilder($origin);

        $this->assertEquals($client, $cached->build());
        $this->assertEquals($client, $cached->build());
    }
}
