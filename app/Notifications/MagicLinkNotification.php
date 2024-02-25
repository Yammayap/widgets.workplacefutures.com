<?php

namespace App\Notifications;

use App\Models\MagicLink;
use App\Models\User;
use App\Support\Helpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLinkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param \App\Models\MagicLink $magicLink
     */
    public function __construct(private readonly MagicLink $magicLink)
    {
    }

    /**
     * @param \App\Models\User $notifiable
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(
                'Sign in to ' . config('app.name') .
                ' [' . Helpers::formatDateTime($this->magicLink->requested_at) . ']'
            )
            ->greeting(
                $notifiable->name === '' ? 'Hello,' : 'Hello ' . $notifiable->name . ','
            )
            ->line('Click the button below to securely sign in.')
            ->action('Sign in', $this->magicLink->signedUrl)
            ->line('This magic link will expire at ' . Helpers::formatDateTime($this->magicLink->expires_at) . '.');
    }
}
