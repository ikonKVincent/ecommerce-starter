<?php

namespace App\View\Components\Fields;

use App\Models\Settings\Language;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Translatable extends Component
{
    /**
     * Whether translations should be expanded.
     */
    public bool $expanded = false;

    /**
     * Create a new instance of the component.
     */
    public function __construct(bool $expanded = false)
    {
        $this->expanded = $expanded;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $languages = Language::query()->whereDefault(false)->get();
        return view('components.fields.translatable', [
            'default' => Language::whereDefault(true)->first(),
            'languages' => $languages,
            'showTranslatable' => $languages->count() > 0 ? true : false,
        ]);
    }
}
