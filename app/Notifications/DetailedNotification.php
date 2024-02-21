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
     * Create a new notification instance.
     */
    public function __construct(private readonly Enquiry $enquiry)
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
        // todo: PDF attachment
        // todo: email content - this is mostly just a copy of the summary notification for now
        return (new MailMessage())
            ->subject('Your space calculator results in more detail')
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('Thank you for using the space calculator with ' . $this->enquiry->tenant->label()
                . '. Your results are attached to this email.')

            /* todo: the action is a placeholder route, where would it link?
            (perhaps address this when PDF attached) */

            ->action('Lorem ipsum', route('web.space-calculator.index'));

            // todo: WFG may like to have some marketing text in this email
    }
}
