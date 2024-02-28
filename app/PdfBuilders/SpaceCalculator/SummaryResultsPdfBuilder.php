<?php

namespace App\PdfBuilders\SpaceCalculator;

use App\Models\Enquiry;
use App\PdfBuilders\PdfBuilder;
use App\Services\SpaceCalculator\Calculator;

class SummaryResultsPdfBuilder extends PdfBuilder
{
    /**
     * @var string
     */
    public string $view;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        parent::__construct($calculator);

        $this->view = 'pdfs.space-calculator.summary';
    }

    /**
     * @param Enquiry $enquiry
     * @return array<string,mixed>
     */
    public function setViewParameters(Enquiry $enquiry): array
    {
        return [
            'inputs' => $enquiry->spaceCalculatorInput,
            'outputs' => $this->calculator->calculate($enquiry->spaceCalculatorInput->transformToCalculatorInputs()),
        ];
    }
}
