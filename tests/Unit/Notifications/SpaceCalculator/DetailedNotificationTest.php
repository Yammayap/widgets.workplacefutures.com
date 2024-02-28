<?php

namespace Tests\Unit\Notifications\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Models\User;
use App\Notifications\SpaceCalculator\DetailedNotification;
use App\PdfBuilders\SpaceCalculator\DetailedResultsPdfBuilder;
use Illuminate\Support\Facades\App;
use Spatie\LaravelPdf\PdfBuilder;
use Tests\TestCase;

class DetailedNotificationTest extends TestCase
{
    public function test_detailed_notification_has_attachment(): void
    {
        $user = User::factory()->create();
        $enquiry = Enquiry::factory()->create(['user_id' => $user->id]);
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(DetailedResultsPdfBuilder::class)
            ->shouldReceive('build')
            ->with(
                $this->mockArgModel($enquiry)
            )
            ->once()
            ->andReturn(new PdfBuilder());

        $mail = (App::make(DetailedNotification::class, ['enquiry' => $enquiry]))->toMail($user);

        $this->assertEquals(1, count($mail->rawAttachments));
        $this->assertEquals('space-calculator-detailed-results.pdf', $mail->rawAttachments[0]['name']);
    }
}
