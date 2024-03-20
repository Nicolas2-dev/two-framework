<?php

namespace Two\Notifications;

use Two\Bus\Dispatcher as BusDispatcher;
use Two\Events\Dispatcher as EventDispatcher;
use Two\Foundation\Application;
use Two\Support\Manager;
use Two\Notifications\Channels\BroadcastChannel;
use Two\Notifications\Channels\DatabaseChannel;
use Two\Notifications\Channels\MailChannel;
use Two\Notifications\DispatcherInterface;
use Two\Notifications\NotificationSender;

use InvalidArgumentException;


class ChannelManager extends Manager implements DispatcherInterface
{
    /**
     * The notifications sender instance.
     *
     * @var \Two\Notifications\NotificationSender
     */
    protected $sender;

    /**
     * The default channels used to deliver messages.
     *
     * @var array
     */
    protected $defaultChannel = 'mail';


    /**
     * Create a new manager instance.
     *
     * @param  \Two\Foundation\Application  $app
     * @param  \Two\Events\Dispatcher  $events
     * @param  \Two\Bus\Dispatcher  $bus
     * @return void
     */
    public function __construct(Application $app, EventDispatcher $events, BusDispatcher $bus)
    {
        $this->app = $app;

        //
        $this->sender = new NotificationSender($this, $events, $bus);
    }

    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  \Two\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function send($notifiables, $notification)
    {
        $this->sender->send($notifiables, $notification);
    }

    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  \Two\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @param  array|null  $channels
     * @return void
     */
    public function sendNow($notifiables, $notification, array $channels = null)
    {
        $this->sender->sendNow($notifiables, $notification, $channels);
    }

    /**
     * Get a channel instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create an instance of the database driver.
     *
     * @return \Two\Notifications\Channels\DatabaseChannel
     */
    protected function createDatabaseDriver()
    {
        return $this->app->make(DatabaseChannel::class);
    }

    /**
     * Create an instance of the broadcast driver.
     *
     * @return \Two\Notifications\Channels\BroadcastChannel
     */
    protected function createBroadcastDriver()
    {
        return $this->app->make(BroadcastChannel::class);
    }

    /**
     * Create an instance of the mail driver.
     *
     * @return \Two\Notifications\Channels\MailChannel
     */
    protected function createMailDriver()
    {
        return $this->app->make(MailChannel::class);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        try {
            return parent::createDriver($driver);
        }
        catch (InvalidArgumentException $e) {
            if (! class_exists($driver)) {
                throw $e;
            }

            return $this->app->make($driver);
        }
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->defaultChannel;
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function deliversVia()
    {
        return $this->defaultChannel;
    }

    /**
     * Set the default channel driver name.
     *
     * @param  string  $channel
     * @return void
     */
    public function deliverVia($channel)
    {
        $this->defaultChannel = $channel;
    }
}
