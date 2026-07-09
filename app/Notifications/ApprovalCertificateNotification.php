<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovalCertificateNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
        $approvedBy = $notifiable->approvedBy?->full_name ?? 'System Administrator';
        $approvalDate = $notifiable->approved_at->format('F j, Y \a\t g:i A');

        return (new MailMessage())
            ->subject('Account Approved - Certificate of Authorization')
            ->greeting("Dear {$notifiable->full_name},")
            ->line('We are pleased to inform you that your registration has been approved.')
            ->line('**Certificate of Authorization Details:**')
            ->line("**Full Name:** {$notifiable->full_name}")
            ->line("**Organization:** {$notifiable->organization}")
            ->line("**Designation:** {$notifiable->designation}")
            ->line("**Approved By:** {$approvedBy}")
            ->line("**Approval Date:** {$approvalDate}")
            ->line("**Certificate Reference Number:** {$notifiable->approval_certificate_token}")
            ->line('---')
            ->line('Congratulations! You now have full access to the system. A separate email with your login link has been sent.')
            ->line('Please keep this certificate for your records.');
    }
}
