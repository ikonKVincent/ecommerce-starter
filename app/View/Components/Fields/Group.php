<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Group extends Component
{
    /**
     * The error for this input group.
     */
    public ?string $error;

    /**
     * Determine whether error icon should be shown.
     */
    public bool $errorIcon = true;

    /**
     * An array of validation errors.
     */
    public array $errors = [];

    /**
     * Specify what input this label is bound to.
     */
    public string $for;

    /**
     * Any instructions which should be rendered.
     */
    public ?string $hint;

    /**
     * The label for the group.
     */
    public string $label;

    /**
     * Whether this input group is required.
     */
    public bool $required = false;

    /**
     * Create the component instance.
     */
    public function __construct(
        string $label,
        string $for,
        ?string $error = null,
        ?string $hint = null,
        bool $required = false,
        array $errors = [],
        bool $errorIcon = true
    ) {
        $this->label = $label;
        $this->for = $for;
        $this->error = $error;
        $this->hint = $hint;
        $this->required = $required;
        $this->errors = $errors;
        $this->errorIcon = $errorIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fields.group');
    }
}
