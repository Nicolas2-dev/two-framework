<?php

namespace Two\Notifications;

use Two\Bus\QueueableTrait;
use Two\Queue\ShouldQueueInterface;
use Two\Queue\SerializesModelsTrait;

use Two\Notifications\ChannelManager;


class SendQueuedNotifications implements ShouldQueueInterface
{
    use QueueableTrait, SerializesModelsTrait;

    /**
     * The notifiable entities that should receive the notification.
     *
     * @var \Two\Support\Collection
     */
    protected $notifiables;

    /**
     * The notification to be sent.
     *
     * @var \Two\Notifications\Notification
     */
    protected $notification;

    /**
     * All of the channels to send the notification too.
     *
     * @var array
     */
    protected $channels;


    /**
     * Create a new job instance.
     *
     * @param  \Two\Support\Collection  $notifiables
     * @param  \Two\Notifications\Notification  $notification
     * @param  array  $channels
     * @return void
     */
    public function __construct($notifiables, $notification, array $channels = null)
    {
        $this->channels = $channels;
        $this->notifiables = $notifiables;
        $this->notification = $notification;
    }

    /**
     * Send the notifications.
     *
     * @param  \Two\Notifications\ChannelManager  $manager
     * @return void
     */
    public function handle(ChannelManager $manager)
    {
        $manager->sendNow($this->notifiables, $this->notification, $this->channels);
    }
}
