<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $loginUrl,
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
            ->subject('Your Login Link')
            ->greeting("Hello {$notifiable->full_name},")
            ->line('You requested a login link for your account. Click the button below to log in.')
            ->action('Log In to Your Account', $this->loginUrl)
            ->line('This link will expire in 15 minutes.')
            ->line('⚠️ Do not share this link with anyone. It provides direct access to your account.')
            ->line('If you did not request this link, you can safely ignore this email.');
    }
}
