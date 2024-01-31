<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Whether or not the input has an error to show.
     * @var bool
     */
    public bool $error = false;

    /**
     * @var string|null
     */
    public ?string $value = null;

    /**
     * Initialise the component.
     */
    public function __construct(?string $value = null, bool $error = false)
    {
        $this->error = $error;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fields.textarea');
    }
}
