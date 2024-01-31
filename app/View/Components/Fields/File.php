<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    /**
     * Whether or not the input has an error to show.
     */
    public bool $error = false;

    /**
     * Initialise the component.
     *
     * @param  bool $error
     */
    public function __construct(bool $error = false)
    {
        $this->error = $error;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fields.file');
    }
}
