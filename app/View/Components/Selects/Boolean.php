<?php

namespace App\View\Components\Selects;

class Boolean extends Select
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
        return 'choice';
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
