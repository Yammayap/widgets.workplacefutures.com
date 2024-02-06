<?php

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * @param bool $allowBlank
     * @param Collection<int, array<int, int|string>> $options
     * @param string|int|null $selected
     */
    public function __construct(
        public readonly bool $allowBlank = false,
        public readonly Collection $options = new Collection(),
        public readonly string|int|null $selected = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.select');
    }
}
