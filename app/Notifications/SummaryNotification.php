<?php

namespace App\Notifications;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SummaryNotification extends Notification implements ShouldQueue
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
        return (new MailMessage())
            ->subject('Your space calculator results')
            ->greeting('Hi ' . $notifiable->name . ',')
            ->line('Thank you for using the space calculator with ' . $this->enquiry->tenant->label()
                . '. Your results are attached to this email.')

            // In the line above, using $enquiry model to avoid Larastan error

            // todo: discuss - the action is a placeholder route, where would it link?
            // If it was a user we could link to the portal
            // If it was a guest then it will be different and their sessions may have expired

            ->action('Lorem ipsum', route('space-calculator.index'));

            // todo: WFG may like to have some marketing text in this email
    }
}
