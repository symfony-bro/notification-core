<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */


namespace SymfonyBro\NotificationCore\Driver\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class TelegramClient
 * @package SymfonyBro\NotificationCore\Driver\Telegram
 */
class TelegramClient
{
    /**
     * @var string
     */
    private $baseUri;
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var array
     */
    private $options;
    /**
     * @var string
     */
    private $token;

    /**
     * TelegramClient constructor.
     * @param string $token
     * @param array $options
     * @param string $baseUri
     * @param string $pattern
     */
    public function __construct(string $token, array $options = [], $baseUri = 'https://api.telegram.org', $pattern = '/bot<token>/<method>')
    {
        $this->token = $token;
        $this->options = $options;
        $this->baseUri = $baseUri;
        $this->pattern = $pattern;
    }

    /**
     * @param string $method
     * @param array $data
     * @param int $timeout
     * @return bool|mixed
     */
    public function call(string $method, array $data, int $timeout = 10)
    {
        $url = str_replace(['<method>', '<token>'], [$method, $this->token], $this->pattern);

        $post_data = http_build_query($data);
        $client = new Client(array_merge([
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded',
                'Content-length' => \strlen($post_data),
                'Connection' => 'close',
            ],
            'base_uri' => $this->baseUri,
            'timeout' => $timeout,
        ], $this->options));
        try {
            $response = $client->request('POST', $url, [
                'body' => $post_data,
            ]);
        } catch (GuzzleException $e) {
            return false;
        }

        return $response->getStatusCode() === 200 ? json_decode($response->getBody(), true): false;
    }
}
