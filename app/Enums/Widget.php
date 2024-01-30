<?php

namespace App\Enums;

use App\Enums\Contracts\HasLabel;

enum Widget: string implements HasLabel
{
    case SPACE_CALCULATOR = 'space-calculator';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SPACE_CALCULATOR => 'Space Calculator',
        };
    }

    /**
     * @return array<string,mixed>
     */
    public function config(): array
    {
        return match ($this) {
            self::SPACE_CALCULATOR => config('widgets.space-calculator'),
        };
    }
}
