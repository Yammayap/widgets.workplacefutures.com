<?php

namespace App\Notifications\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\User;
use App\PdfBuilders\SpaceCalculatorPdfBuilder;
use App\Services\SpaceCalculator\Calculator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param SpaceCalculatorPdfBuilder $spaceCalculatorPdfBuilder
     * @param Enquiry $enquiry
     * @param Calculator $calculator
     */
    public function __construct(
        private readonly SpaceCalculatorPdfBuilder $spaceCalculatorPdfBuilder,
        private readonly Calculator $calculator,
        private readonly Enquiry $enquiry,
    ) {
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
                $notifiable->name === '' ? 'Hello,' : 'Hello ' . $notifiable->name . ','
            )
            ->line(
                'Thank you for using the ' . $this->enquiry->tenant->label() . ' space calculator. ' .
                'Your summary results are attached to this email.'
            )
            ->attach(
                $this->spaceCalculatorPdfBuilder->summaryResults(
                    $this->enquiry,
                    $this->enquiry->spaceCalculatorInput,
                    $this->calculator->calculate($this->enquiry->spaceCalculatorInput->transformToCalculatorInputs()),
                )->base64()
            );
    }
}
