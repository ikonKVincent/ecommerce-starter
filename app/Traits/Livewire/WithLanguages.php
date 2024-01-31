<?php

namespace App\Traits\Livewire;

use App\Models\Settings\Language;
use Illuminate\Support\Collection;

trait WithLanguages
{
    /**
     * Getter for default language.
     *
     * @return Language
     */
    public function getDefaultLanguageProperty(): Language
    {
        return $this->languages->first(fn ($language) => $language->default);
    }
    /**
     * Getter for all languages in the system.
     *
     * @return Collection
     */
    public function getLanguagesProperty(): Collection
    {
        return Language::get();
    }
}
