<?php
/**
 * @author Artem Dekhtyar <m@artemd.ru>
 * @author Pavel Stepanets <pahhan.ne@gmail.com>
 */

namespace SymfonyBro\NotificationCore\Model;

use Throwable;

abstract class AbstractNotificator implements NotificatorInterface
{
    /**
     * @var RecipientFinderInterface
     */
    private $recipientFinder;

    /**
     * @var TemplateFinderInterface
     */
    private $templateFinder;

    /**
     * @var SenderInterface
     */
    private $sender;

    /**
     * AbstractNotificator constructor.
     * @param RecipientFinderInterface $recipientFinder
     * @param TemplateFinderInterface $templateFinder
     */
    public function __construct(RecipientFinderInterface $recipientFinder, TemplateFinderInterface $templateFinder, SenderInterface $sender)
    {
        $this->recipientFinder = $recipientFinder;
        $this->templateFinder = $templateFinder;
        $this->sender = $sender;
    }

    /**
     * @param ContextInterface $context
     */
    public function notify(ContextInterface $context)
    {
        $recipients = $this->recipientFinder->find($context);
        $templates = $this->templateFinder->find($context);

        foreach ($recipients as $recipient) {
            foreach ($templates as $template) {
                $this->beforeSend($context, $recipient, $template);

                try {
                    $this->sender->send($context, $recipient, $template);
                } catch (Throwable $e) {
                    $this->onSendException($e, $context, $recipient, $template);
                }
                $this->afterSend($context, $recipient, $template);
            }
        }
    }

    protected function beforeSend(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template) {}

    protected function afterSend(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template) {}

    protected function onSendException(Throwable $e, ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template) {}
}