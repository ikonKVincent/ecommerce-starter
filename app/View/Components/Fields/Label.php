<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    /**
     * Specify what input this label is bound to.
     * @var string
     */
    public string $for;

    /**
     * The label name
     * @var string
     */
    public string $label;

    /**
     * Whether this input group is required.
     * @var bool
     */
    public bool $required = false;

    /**
     * Create the component instance.
     */
    public function __construct(
        string $label,
        string $for,
        bool $required = false,
    ) {
        $this->label = $label;
        $this->for = $for;
        $this->required = $required;;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fields.label');
    }
}
