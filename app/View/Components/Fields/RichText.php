<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RichText extends Component
{
    /**
     * Whether or not the input has an error to show.
     */
    public bool $error = false;

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
        return view('components.fields.rich-text');
    }
}
