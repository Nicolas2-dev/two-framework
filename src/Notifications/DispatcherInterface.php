<?php

namespace Two\Notifications;


interface DispatcherInterface
{
    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  \Two\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function send($notifiables, $notification);
}
