<?php

namespace App\View\Components\Alerts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Error extends Component
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
     * Create a new instance of the component.
     *
     * @param string|null $error
     * @param array $errors
     * @param bool $errorIcon
     */
    public function __construct(?string $error = null, array $errors = [], bool $errorIcon = true)
    {
        $this->error = $error;
        $this->errors = $errors;
        $this->errorIcon = $errorIcon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alerts.error');
    }
}
