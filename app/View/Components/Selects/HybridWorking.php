<?php

namespace App\View\Components\Selects;

use App\Enums\Widgets\SpaceCalculator\HybridWorking as HybridWorkingEnum;

class HybridWorking extends Select
{
    /**
     * @param string $label
     * @param string|null $name
     * @param string|null $selected
     * @param string|null $placeholder
     * @param bool $required
     * @param bool $disableLabel
     * @param bool $allowBlank
     * @param array<int, string> $classes
     */
    public function __construct(
        string $label,
        string $name = null,
        string $selected = null,
        string $placeholder = null,
        bool $required = false,
        bool $disableLabel = false,
        bool $allowBlank = false,
        array $classes = array(),
    ) {
        parent::__construct(
            $label,
            $name,
            $selected,
            $placeholder,
            $required,
            $disableLabel,
            $allowBlank,
            $classes,
        );
    }

    /**
     * @return string
     */
    protected function defaultName(): string
    {
        return 'hybrid_working';
    }

    /**
     * @return array<string, string>
     */
    protected function options(): array
    {
        $output = array();

        foreach (HybridWorkingEnum::cases() as $case) {
            $output[$case->value] = $case->label();
        }

        return $output;
    }
}
