<?php

namespace SymfonyBro\NotificationCore\Driver\Slack;

/**
 * Class SlackClient
 *
 * @package SymfonyBro\NotificationCore\Driver\Slack
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class SlackClient
{
    private $api_endpoint;

    public function __construct($endpoint = 'https://slack.com/api')
    {
        $this->api_endpoint = trim($endpoint, '/') . '/<method>';
    }

    public function call($method, $args = array(), $timeout = 10)
    {
        $url = str_replace('<method>', $method, $this->api_endpoint);
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
            $result = file_get_contents($url, false, stream_context_create(array(
                'http' => array(
                    'protocol_version' => 1.1,
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                        "Content-length: " . strlen($post_data) . "\r\n" .
                        "Connection: close\r\n",
                    'content' => $post_data
                ),
            )));
        }
        return $result ? json_decode($result, true) : false;
    }
}
