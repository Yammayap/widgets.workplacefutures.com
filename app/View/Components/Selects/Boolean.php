<?php

namespace App\View\Components\Selects;

class Boolean extends Select
{
    /**
     * @param string $name
     * @param string $label
     * @param string|null $selected
     * @param string|null $placeholder
     * @param bool $required
     * @param bool $disableLabel
     * @param bool $allowBlank
     * @param array<int, string> $classes
     */
    public function __construct(
        string $name,
        string $label,
        string $selected = null,
        string $placeholder = null,
        bool $required = false,
        bool $disableLabel = false,
        bool $allowBlank = false,
        array $classes = array(),
    ) {
        parent::__construct(
            $name,
            $label,
            $selected,
            $placeholder,
            $required,
            $disableLabel,
            $allowBlank,
            $classes,
        );
    }

    /**
     * @return array<int, string>
     */
    protected function options(): array
    {
        return [
            0 => 'No',
            1 => 'Yes',
        ];
    }
}
