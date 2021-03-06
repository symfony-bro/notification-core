<?php
/**
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 * @author Artem Dekhtyar <m@artemd.ru>
 */

namespace SymfonyBro\NotificationCore\Driver\Firebase;

use GuzzleHttp\ClientInterface;

interface ClientBuilderInterface
{
    public function build(): ClientInterface;
}