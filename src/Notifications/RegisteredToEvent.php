<?php

namespace TypiCMS\Modules\Events\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredToEvent extends Notification
{
    use Queueable;

    private $event;
    private $registration;

    /**
     * Create a new notification instance.
     *
     * @param mixed $event
     * @param mixed $registration
     */
    public function __construct($event, $registration)
    {
        $this->event = $event;
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Your registration to “' . $this->event->title . '”.')
            ->markdown('events::mail.your-registration-to-event', ['event' => $this->event, 'registration' => $this->registration]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
