<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class Errors extends Component
{
    /**
     * Errors constructor.
     *
     * @param ViewErrorBag $errorBag
     */
    public function __construct(public readonly ViewErrorBag $errorBag)
    {
        //
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('components.errors');
    }
}
