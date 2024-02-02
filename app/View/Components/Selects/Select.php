<?php

namespace App\View\Components\Selects;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class Select extends Component
{
    /**
     * @var string
     */
    public readonly string|null $name;

    /**
     * @var string
     */
    public readonly string $label;

    /**
     * @var string|null
     */
    public readonly string|null $selected;

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
     * @var bool
     */
    public readonly bool $allowBlank;

    /**
     * @var array<int, string>
     */
    public readonly array $classes;

    /**
     * @var array<string|int, string>
     */
    public readonly array $options;

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
        string $label,
        ?string $name = null,
        string $selected = null,
        string $placeholder = null,
        bool $required = false,
        bool $disableLabel = false,
        bool $allowBlank = false,
        array $classes = array(),
    ) {
        $this->name = !is_null($name) ? $name : $this->defaultName();
        $this->label = $label;
        $this->selected = $selected;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disableLabel = $disableLabel;
        $this->allowBlank = $allowBlank;
        $this->classes = $classes;
        $this->options = $this->options();
    }

    /**
     * @return string
     */
    abstract protected function defaultName(): string;

    /**
     * @return array<int|string,string>
     */
    abstract protected function options(): array;

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.select');
    }
}
