<?php

namespace Tests\Unit\PdfBuilders\SpaceCalculator;

use Tests\TestCase;

class SummaryResultsPdfBuilderTest extends TestCase
{
    public function test_pdf_is_returned()
    {
        /*Pdf::fake();
        // todo: discuss - not sure we can use what is in the url https://spatie.be/docs/laravel-pdf/v1/basic-usage/testing-pdfs because we are not saving the PDF and the way we are returning it

        $enquiry = Enquiry::factory()->create();
        $inputs = SpaceCalculatorInput::factory()->create(['enquiry_id' => $enquiry->id]);

        $calculator = app()->make(Calculator::class);
        $outputs = $calculator->calculate($inputs->transformToCalculatorInputs());

        $builder = app()->make(SummaryResultsPdfBuilder::class);

        $pdf = $builder->summaryResults(
            $enquiry,
            $inputs,
            $outputs,
        );

        $this->assertEquals('pdfs.space-calculator.summary', $pdf->viewName);*/
    }
}
