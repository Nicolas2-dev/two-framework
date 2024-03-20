<?php

namespace Two\Notifications\Models;

use Two\Database\ORM\Collection;


class NotificationCollection extends Collection
{
    /**
     * Mark all notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->each(function ($notification)
        {
            $notification->markAsRead();
        });
    }
}
