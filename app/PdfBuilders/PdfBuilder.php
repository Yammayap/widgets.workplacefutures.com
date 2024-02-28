<?php

namespace App\PdfBuilders;

use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder as SpatiePdfBuilder;

abstract class PdfBuilder
{
    /**
     * @param string $view
     * @param array<string, mixed> $viewParameters
     * @return SpatiePdfBuilder
     */
    protected function buildPdf(string $view, array $viewParameters): SpatiePdfBuilder
    {
        /**
         * @var SpatiePdfBuilder $pdf
         */
        $pdf = Pdf::view($view, $viewParameters)
            ->headerView('pdfs.header')
            ->footerView('pdfs.footer')
            ->format(Format::A4)
            ->margins(17, 10, 35, 10); // real numbers TBC

        return $pdf;
    }
}
