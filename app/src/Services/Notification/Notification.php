<?php

namespace App\Services\Notification;

class Notification
{
    public NotifyInterface $notifier;

    /**
     * @param NotifyInterface $notifier
     * @return $this
     */
    public function setNotifier(NotifyInterface $notifier): self
    {
        $this->notifier = $notifier;

        return $this;
    }

    /**
     * @param string $title
     * @param string $message
     * @return self
     */
    public function notify(string $title, string $message): self
    {
        $this->notifier->notify($title, $message);

        return $this;
    }
}