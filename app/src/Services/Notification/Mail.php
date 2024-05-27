<?php

namespace App\Services\Notification;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail implements NotifyInterface
{
    /**
     * @param string $email
     * @param MailerInterface $mailer
     */
    public function __construct(public readonly string $email, public readonly MailerInterface $mailer){}

    /**
     * @param string $title
     * @param string $message
     * @return bool
     * @throws TransportExceptionInterface
     */
    public function notify(string $title, string $message): bool
    {
        $email = (new Email())
            ->from('loanassistent@americor.com')
            ->to($this->email)
            ->subject($title)
            ->text($message);

        try {
            $this->mailer->send($email);
        } catch (\Exception $exception) {
           return false;
        }

        return true;
    }
}