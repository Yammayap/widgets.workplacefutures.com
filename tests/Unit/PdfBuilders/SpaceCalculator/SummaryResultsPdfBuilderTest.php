<?php

namespace Tests\Unit\PdfBuilders\SpaceCalculator;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\PdfBuilders\SpaceCalculator\SummaryResultsPdfBuilder;
use App\Services\SpaceCalculator\Calculator;
use App\Services\SpaceCalculator\Output;
use App\Services\SpaceCalculator\OutputAreaSize;
use Spatie\LaravelPdf\Facades\Pdf;
use Tests\TestCase;

class SummaryResultsPdfBuilderTest extends TestCase
{
    public function test_pdf_is_returned()
    {
        Pdf::fake();

        $enquiry = Enquiry::factory()->create();
        SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $this->mock(Calculator::class)
            ->shouldReceive("calculate")
            ->andReturn(new Output(
                areaSize: new OutputAreaSize(0, 0, 0, 0, 0, 0),
                assets: collect(),
                capacityTypes: collect(),
                areaTypes: collect(),
            ));

        $builder = app()->make(SummaryResultsPdfBuilder::class);

        $pdf = $builder->build($enquiry);

        $this->assertEquals('pdfs.space-calculator.summary', $pdf->viewName);
    }
}
