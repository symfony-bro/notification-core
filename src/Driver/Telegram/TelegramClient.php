<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */


namespace SymfonyBro\NotificationCore\Driver\Telegram;

/**
 * Class TelegramClient
 * @package SymfonyBro\NotificationCore\Driver\Telegram
 */
class TelegramClient
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * TelegramClient constructor.
     * @param string $endpoint
     */
    public function __construct($endpoint = 'https://api.telegram.org/bot<token>/<method>')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param $token
     * @param $method
     * @param array $args
     * @param int $timeout
     * @return bool|mixed
     */
    public function call($token, $method, array $args = [], $timeout = 10)
    {
        $url = str_replace(['<method>', '<token>'], [$method, $token], $this->endpoint);

        if (function_exists('curl_version')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $post_data = http_build_query($args);
            $result = file_get_contents($url, false, stream_context_create([
                'http' => [
                    'protocol_version' => 1.1,
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                        'Content-length: ' . strlen($post_data) . "\r\n" .
                        "Connection: close\r\n",
                    'content' => $post_data
                ],
            ]));
        }
        return $result ? json_decode($result, true) : false;
    }
}
