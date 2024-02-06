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
     * @param ViewErrorBag $errors
     */
    public function __construct(public readonly ViewErrorBag $errors)
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

    /**
     * @return bool
     */
    public function shouldRender(): bool
    {
        return $this->errors->isNotEmpty();
    }
}
