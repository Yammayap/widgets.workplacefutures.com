<?php

namespace Tests\Unit\Notifications\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SpaceCalculator\SummaryNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SummaryNotificationTest extends TestCase
{
    public function test_summary_notification_has_attachment(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $user->notify(App::make(
            SummaryNotification::class,
            ['enquiry' => $enquiry]
        ));

        Notification::assertSentTo(
            $user,
            SummaryNotification::class,
            function ($notification, $channels, $notifiable) {
                /* todo: discuss - should we assert more here? Feels like asserting base64 contents shouldn't
                be done here */
                return count($notification->toMail($notifiable)->rawAttachments) == 1
                    && $notification->toMail($notifiable)->rawAttachments[0]['name']
                    == 'space-calculator-summary-results.pdf';
            }
        );
    }
}
