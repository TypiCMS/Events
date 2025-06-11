<?php

namespace TypiCMS\Modules\Events\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredToEvent extends Notification
{
    use Queueable;

    public function __construct(private readonly mixed $event, private readonly mixed $registration) {}

    /** @return string[] */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->subject('Your registration to “' . $this->event->title . '”.')
            ->markdown('events::mail.your-registration-to-event', ['event' => $this->event, 'registration' => $this->registration]);
    }
}
