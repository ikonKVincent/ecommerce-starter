<?php

namespace App\View\Components\Fields;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Boolean extends Component
{
    /**
     * Whether the toggle should be checked.
     *
     * @var bool
     */
    public $checked = false;

    /**
     * Whether the toggle should be disabled.
     *
     * @var bool
     */
    public $disabled = false;

    /**
     * Whether or not the input has an error to show.
     *
     * @var bool
     */
    public bool $error = false;

    /**
     * The id for the input.
     *
     * @var string
     */
    public string $id;

    /**
     * Initialise the component.
     */
    public function __construct(?string $id = null, bool $error = false, bool $disabled = false, bool $checked = false)
    {
        $this->id = $id ?? Str::random(10);
        $this->error = $error;
        $this->disabled = $disabled;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fields.boolean');
    }
}
