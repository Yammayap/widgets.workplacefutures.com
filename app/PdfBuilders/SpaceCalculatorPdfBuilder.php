<?php

namespace App\PdfBuilders;

use App\Models\Enquiry;
use Spatie\LaravelPdf\PdfBuilder;

class SpaceCalculatorPdfBuilder
{
    public function __construct(private readonly PdfBuilder $pdfBuilder)
    {
        //
    }

    /**
     * @param Enquiry $enquiry
     * @return PdfBuilder
     */
    public function summaryResults(Enquiry $enquiry): PdfBuilder
    {
        return $this->pdfBuilder
            ->view('pdfs.space-calculator.summary', [
                'enquiry' => $enquiry
        ]);
    }
}
