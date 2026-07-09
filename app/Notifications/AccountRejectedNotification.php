<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $reason,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Registration Update')
            ->greeting("Dear {$notifiable->full_name},")
            ->line('We regret to inform you that your registration has not been approved.')
            ->line('**Reason:** ' . $this->reason)
            ->line('If you believe this decision was made in error, please contact our support team for assistance.')
            ->line('Thank you for your interest.');
    }
}
