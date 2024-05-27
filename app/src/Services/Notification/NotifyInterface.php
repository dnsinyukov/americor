<?php

namespace App\Services\Notification;

interface NotifyInterface
{
    public function notify(string $title, string $message): bool;
}