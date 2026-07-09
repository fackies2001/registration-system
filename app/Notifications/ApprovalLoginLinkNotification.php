<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalLoginLinkNotification extends Notification implements ShouldQueue
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
            ->subject('Your Account Has Been Approved - Access Your Dashboard')
            ->greeting("Congratulations {$notifiable->full_name}!")
            ->line('Your account has been approved and you now have full access to the system.')
            ->line('Click the button below to log in and access your dashboard.')
            ->action('Access Your Dashboard', $this->loginUrl)
            ->line('This login link will expire in 15 minutes. You can always request a new one from the login page.')
            ->line('Welcome aboard!');
    }
}
