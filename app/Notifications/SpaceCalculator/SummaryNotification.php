<?php

namespace App\Notifications\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\User;
use App\PdfBuilders\SpaceCalculator\SummaryResultsPdfBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class SummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param Enquiry $enquiry
     */
    public function __construct(private readonly Enquiry $enquiry)
    {
        //
    }

    /**
     * @param User $notifiable
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param User $notifiable
     *
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Space calculator summary results')
            ->greeting(
                $notifiable->name ? 'Hello ' . $notifiable->name . ',' : 'Hello,'
            )
            ->line(
                'Thank you for using the ' . $this->enquiry->tenant->label() . ' space calculator. ' .
                'Your summary results are attached to this email.'
            )
            ->attachData(
                base64_decode(
                    App::make(SummaryResultsPdfBuilder::class)->build($this->enquiry)->base64()
                ),
                'space-calculator-summary-results.pdf',
            );
    }
}
