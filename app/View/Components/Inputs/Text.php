<?php

namespace App\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    /**
     * @var string
     */
    public readonly string $name;

    /**
     * @var string
     */
    public readonly string $label;

    /**
     * @var string
     */
    public readonly string $type;

    /**
     * @var string|null
     */
    public readonly string|null $value;

    /**
     * @var string|null
     */
    public readonly string|null $placeholder;

    /**
     * @var bool
     */
    public readonly bool $required;

    /**
     * @var bool
     */
    public readonly bool $disableLabel;

    /**
     * @var array<int, string>
     */
    public readonly array $classes;

    /**
     * @param string $name
     * @param string $label
     * @param string $type
     * @param string|null $value
     * @param string|null $placeholder
     * @param bool $required
     * @param bool $disableLabel
     * @param array<int, string> $classes
     */
    public function __construct(
        string $name,
        string $label,
        string $type = 'text',
        string $value = null,
        string $placeholder = null,
        bool $required = false,
        bool $disableLabel = false,
        array $classes = array(),
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disableLabel = $disableLabel;
        $this->classes = $classes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.inputs.text');
    }
}
