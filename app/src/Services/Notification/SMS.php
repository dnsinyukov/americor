<?php

namespace App\Services\Notification;

class SMS implements NotifyInterface
{
    /**
     * @param string $phone
     */
    public function __construct(public readonly string $phone) {}

    public function notify(string $title, string $message): bool
    {
        echo "Notification send from: SMS \n";

        return true;
    }
}