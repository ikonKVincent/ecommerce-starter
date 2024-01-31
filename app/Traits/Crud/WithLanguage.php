<?php

namespace App\Traits\Crud;

use App\Models\Settings\Language;
use Illuminate\Support\Collection;

trait WithLanguage
{
    public Language $defaultLanguage;

    public Collection $languages;

    public function __construct()
    {
        $this->languages = $this->getLanguagesProperty();
        $this->defaultLanguage = $this->getDefaultLanguageProperty();
        parent::__construct();
    }

    /**
     * Get Default Language
     * @return Language
     */
    public function getDefaultLanguageProperty(): Language
    {
        return Language::where('default', true)->first();
    }

    /**
     * Get Languages
     * @return Collection
     */
    public function getLanguagesProperty(): Collection
    {
        return Language::get();
    }
}
