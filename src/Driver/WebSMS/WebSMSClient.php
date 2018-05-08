<?php
/**
 * @author Anikeev Dmitry <dm.anikeev@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Driver\WebSMS;

use \LogicException;
use \RuntimeException;
use \SimpleXMLElement;
use function \function_exists;
use function \curl_init;
use function \curl_setopt;
use function \curl_exec;
use function \curl_error;
use function \curl_close;
use function \count;

/**
 * Class WebSMSClient
 * @package SymfonyBro\NotificationCore\Driver\WebSMS
 */
class WebSMSClient
{
    public const RESPONSE_UNKNOWN = 13;

    private $args;

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    public function call(array $recipients, string $body)
    {
        if (!function_exists('curl_version')) {
            throw new LogicException('Not implemented');
        }

        $xml = $this->buildXml($recipients, $body);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->args['endpoint']);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml->asXML());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: text/xml'
        ]);

        $data = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($data === false) {
            throw new RuntimeException($error);
        }

        $response = new SimpleXMLElement($data);

        /* @var $state SimpleXMLElement */
        foreach ($response->state as $state) {
            $errCode = (int)$state->attributes()->errcode;
            $error = (string)$state->attributes()->error;
            if (self::RESPONSE_UNKNOWN === $errCode) {
                throw new RuntimeException($error);
            }
        }
        return ['ok'];
    }

    /**
     * @param array $recipients
     * @param string $body
     * @return SimpleXMLElement
     */
    private function buildXml(array $recipients, string $body): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<message></message>');
        $service = $xml->addChild('service');
        $service->addAttribute('id', count($recipients) > 1 ? 'bulk' : 'single');
        $service->addAttribute('login', $this->args['login']);
        $service->addAttribute('password', $this->args['password']);
        $service->addAttribute('test', (int)$this->args['test']);

        foreach ($recipients as $to) {
            $xml->addChild('to', $to);
        }

        $xml->addChild('body', $body);

        return $xml;
    }
}