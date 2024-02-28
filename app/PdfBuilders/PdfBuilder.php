<?php

namespace App\PdfBuilders;

use App\Models\Enquiry;
use App\Services\SpaceCalculator\Calculator;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder as SpatiePdfBuilder;

abstract class PdfBuilder
{
    /**
     * @var string
     */
    public string $view;

    public function __construct(public readonly Calculator $calculator)
    {
        $this->view = ''; // todo: discuss this var
    }

    /**
     * @return array<string,mixed>
     */
    abstract protected function setViewParameters(Enquiry $enquiry): array;

    /**
     * @param Enquiry $enquiry
     * @return SpatiePdfBuilder
     */
    public function build(Enquiry $enquiry): SpatiePdfBuilder
    {
        /**
         * @var SpatiePdfBuilder $pdf
         */
        $pdf = Pdf::view($this->view, $this->setViewParameters($enquiry))
            ->headerView('pdfs.header')
            ->footerView('pdfs.footer')
            ->format(Format::A4)
            ->margins(17, 10, 35, 10); // real numbers TBC

        return $pdf;
    }
}
