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
     * Create a new notification instance.
     */
    public function __construct(private readonly MagicLink $magicLink)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Log in to ' . config('app.name')
                . ' [' . Helpers::formatDateTime($this->magicLink->requested_at) . ']')
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('Click the button below to securely log in.')
            ->action('Log in', $this->magicLink->signedUrl)
            ->line('This magic link will expire at ' . Helpers::formatDateTime($this->magicLink->expires_at) . '.');
    }
}
