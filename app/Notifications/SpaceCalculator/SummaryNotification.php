<?php

namespace App\Notifications\SpaceCalculator;

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
            ->subject('Space calculator summary results')
            ->greeting(
                $notifiable->name === '' ? 'Hello,' : 'Hello ' . $notifiable->name . ','
            )
            ->line(
                'Thank you for using the ' . $this->enquiry->tenant->label() . ' space calculator. ' .
                'Your summary results are attached to this email.'
            );
    }
}