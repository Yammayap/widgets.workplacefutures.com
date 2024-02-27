<?php

namespace App\PdfBuilders;

use App\Models\Enquiry;
use App\Models\SpaceCalculatorInput;
use App\Services\SpaceCalculator\Output;
use Spatie\LaravelPdf\PdfBuilder;

class SpaceCalculatorPdfBuilder
{
    public function __construct(private readonly PdfBuilder $pdfBuilder)
    {
        //
    }

    /**
     * @param Enquiry $enquiry
     * @param SpaceCalculatorInput $inputs
     * @param Output $outputs
     * @return PdfBuilder
     */
    public function summaryResults(Enquiry $enquiry, SpaceCalculatorInput $inputs, Output $outputs): PdfBuilder
    {
        /* todo: discuss - some things here like margins, header and footer will likely be the same everywhere
        maybe this can be deferred but once we know what the PDFs look like we could create a base / default
        function? Maybe it would just run a function get the required view name and data? */
        return $this->pdfBuilder
            ->view('pdfs.space-calculator.summary', [
                'enquiry' => $enquiry,
                'inputs' => $inputs,
                'outputs' => $outputs,
            ])
            ->headerView('pdfs.header')
            ->footerView('pdfs.footer')
            ->margins(17, 10, 35, 10) // real numbers TBC
            ->name('space-calculator-summary-results.pdf');
    }
}
