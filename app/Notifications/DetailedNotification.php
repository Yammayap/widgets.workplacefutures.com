<?php

namespace App\Notifications;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DetailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param \App\Models\Enquiry $enquiry
     */
    public function __construct(private readonly Enquiry $enquiry)
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
     * @param \App\Models\User $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Space calculator detailed results')
            ->greeting(
                $notifiable->name === '' ? 'Hello,' : 'Hello ' . $notifiable->name . ','
            )
            ->line(
                'Thank you for using the ' . $this->enquiry->tenant->label() . ' space calculator. ' .
                'Your detailed results are attached to this email.'
            );
    }
}
