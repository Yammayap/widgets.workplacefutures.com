<?php

namespace App\Enums\Traits;

use Illuminate\Support\Collection;

trait ProvidesSelectOptions
{
    /**
     * @return Collection<int, array{'value': string, "label": string}>
     */
    public static function toSelectOptions(): Collection
    {
        return (new Collection(self::cases()))
            ->map(function ($enum): array {
                return [
                    'value' => (string) $enum->value,
                    'label' => method_exists($enum, 'label') ? (string) $enum->label() : (string) $enum->value,
                ];
            });
    }
}
