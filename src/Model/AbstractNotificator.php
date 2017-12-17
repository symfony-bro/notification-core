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
     * @var NotificationBuilderInterface
     */
    private $builder;
    /**
     * @var NotificationManagerInterface
     */
    private $manager;

    /**
     * AbstractNotificator constructor.
     * @param RecipientFinderInterface $recipientFinder
     * @param TemplateFinderInterface $templateFinder
     * @param NotificationBuilderInterface $builder
     * @param NotificationManagerInterface $manager
     */
    public function __construct(RecipientFinderInterface $recipientFinder, TemplateFinderInterface $templateFinder, NotificationBuilderInterface $builder, NotificationManagerInterface $manager)
    {
        $this->recipientFinder = $recipientFinder;
        $this->templateFinder = $templateFinder;
        $this->builder = $builder;
        $this->manager = $manager;
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
                    $notification = $this->builder->build($context, $recipient, $template);
                } catch (Throwable $e) {
                    $this->onBuildException($e, $context, $recipient, $template);
                    continue;
                }

                try {
                    $this->manager->notify($notification);
                } catch (Throwable $e) {
                    $this->onNotifyException($e, $notification);
                    continue;
                }

                $this->afterSend($context, $recipient, $template, $notification);
            }
        }
    }

    protected function beforeSend(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template) {}

    protected function afterSend(ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template, NotificationInterface $notification) {}

    protected function onNotifyException(Throwable $e, NotificationInterface $notification) {}

    private function onBuildException(Throwable $e, ContextInterface $context, RecipientInterface $recipient, TemplateInterface $template) {}
}