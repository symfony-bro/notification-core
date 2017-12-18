<?php

namespace SymfonyBro\NotificationCore\Driver\Slack;

use SymfonyBro\NotificationCore\Model\AbstractMessage;
use SymfonyBro\NotificationCore\Model\NotificationInterface;

/**
 * Class SlackMessage
 *
 * @package SymfonyBro\NotificationCoreBundle\Driver\Slack
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */
class SlackMessage extends AbstractMessage
{

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $payload;

    /**
     * @var bool
     */
    private $mrkdwn;

    /**
     * SlackMessage constructor.
     * @param NotificationInterface $notification
     * @param string $token
     * @param string $method
     */

    public function __construct(NotificationInterface $notification, string $token, $method = 'chat.postMessage')
    {
        parent::__construct($notification);
        $this->method = $method;

        $this->payload['token'] = $token;
    }

    /**
     * @param bool $mrkdwn
     * @return SlackMessage
     */
    public function setMrkdwn(bool $mrkdwn): SlackMessage
    {
        $this->mrkdwn = $mrkdwn;
        return $this;
    }

    /**
     * @param string $channel
     * @return SlackMessage
     */
    public function setChannel(string $channel): SlackMessage
    {
        $this->payload['channel'] = $channel;
        return $this;
    }

    /**
     * @param string $text
     * @return SlackMessage
     */
    public function setText(string $text): SlackMessage
    {
        $this->payload['text'] = $text;
        return $this;
    }

    /**
     * @param string $parse
     * @return SlackMessage
     */
    public function setParse(string $parse): SlackMessage
    {
        $this->payload['parse'] = $parse;
        return $this;
    }

    /**
     * @param bool $link_names
     * @return SlackMessage
     */
    public function setLinkNames(bool $link_names): SlackMessage
    {
        $this->payload['link_names'] = $link_names;
        return $this;
    }

    /**
     * @param array $attachment
     * @return SlackMessage
     */
    public function addAttachment(array $attachment): SlackMessage
    {
        $this->payload['attachments'][] = $attachment;
        return $this;
    }

    /**
     * @return $this
     */
    public function cleanAttachments()
    {
        $this->payload['attachments'] = [];
        return $this;
    }

    /**
     * @param bool $unfurl_links
     * @return SlackMessage
     */
    public function setUnfurlLinks(bool $unfurl_links): SlackMessage
    {
        $this->payload['unfurl_links'] = $unfurl_links;
        return $this;
    }

    /**
     * @param bool $unfurl_media
     * @return SlackMessage
     */
    public function setUnfurlMedia(bool $unfurl_media): SlackMessage
    {
        $this->payload['unfurl_media'] = $unfurl_media;
        return $this;
    }

    /**
     * @param string $username
     * @return SlackMessage
     */
    public function setUsername(string $username): SlackMessage
    {
        $this->payload['username'] = $username;
        return $this;
    }

    /**
     * @param bool $as_user
     * @return SlackMessage
     */
    public function setAsUser(bool $as_user): SlackMessage
    {
        $this->payload['as_user'] = $as_user;
        return $this;
    }

    /**
     * @param string $icon_url
     * @return SlackMessage
     */
    public function setIconUrl(string $icon_url): SlackMessage
    {
        $this->payload['icon_url'] = $icon_url;
        return $this;
    }

    /**
     * @param string $icon_emoji
     * @return SlackMessage
     */
    public function setIconEmoji(string $icon_emoji): SlackMessage
    {
        $this->payload['icon_emoji'] = $icon_emoji;
        return $this;
    }

    /**
     * @param string $thread_ts
     * @return SlackMessage
     */
    public function setThreadTs(string $thread_ts): SlackMessage
    {
        $this->payload['thread_ts'] = $thread_ts;
        return $this;
    }

    /**
     * @param bool $reply_broadcast
     * @return SlackMessage
     */
    public function setReplyBroadcast(bool $reply_broadcast): SlackMessage
    {
        $this->payload['reply_broadcast'] = $reply_broadcast;
        return $this;
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
