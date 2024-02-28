<?php

namespace Tests\Unit\Notifications\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SpaceCalculator\SummaryNotification;
use App\PdfBuilders\SpaceCalculator\SummaryResultsPdfBuilder;
use Illuminate\Support\Facades\App;
use Spatie\LaravelPdf\PdfBuilder;
use Tests\TestCase;

class SummaryNotificationTest extends TestCase
{
    public function test_summary_notification_has_attachment(): void
    {
        $this->mock(SummaryResultsPdfBuilder::class)
            ->shouldReceive('build')
            ->andReturn(new PdfBuilder());

        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $mail = (App::make(SummaryNotification::class, ['enquiry' => $enquiry]))->toMail($user);

        $this->assertEquals(1, count($mail->rawAttachments));
        $this->assertEquals('space-calculator-summary-results.pdf', $mail->rawAttachments[0]['name']);
    }
}
