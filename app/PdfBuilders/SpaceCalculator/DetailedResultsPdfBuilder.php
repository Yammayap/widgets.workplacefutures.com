<?php

namespace App\PdfBuilders\SpaceCalculator;

use App\Models\Enquiry;
use App\PdfBuilders\PdfBuilder;
use App\Services\SpaceCalculator\Calculator;
use Spatie\LaravelPdf\PdfBuilder as SpatiePdfBuilder;

class DetailedResultsPdfBuilder extends PdfBuilder
{
    public function __construct(private readonly Calculator $calculator)
    {
        //
    }

    public function build(Enquiry $enquiry): SpatiePdfBuilder
    {
        return $this->buildPdf(
            'pdfs.space-calculator.detailed',
            [
                'inputs' => $enquiry->spaceCalculatorInput,
                'outputs' => $this->calculator->calculate(
                    $enquiry->spaceCalculatorInput->transformToCalculatorInputs()
                ),
            ]
        );
    }
}
