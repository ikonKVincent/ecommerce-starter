<?php

namespace App\Observers\Settings;

use App\Facades\DB;
use App\Models\Settings\Language;

class LanguageObserver
{
    /**
     * Handle the Language "created" event.
     * @param Language $language
     *
     * @return void
     */
    public function created(Language $language): void
    {
        $this->ensureOnlyOneDefault($language);
    }

    /**
     * Handle the Language "updated" event.
     * @param Language $language
     *
     * @return void
     */
    public function updated(Language $language): void
    {
        $this->ensureOnlyOneDefault($language);
    }

    /**
     * Handle the Language "deleted" event.
     * @param Language $language
     *
     * @return void
     */
    public function deleting(Language $language): void
    {
        DB::transaction(function () use ($language) {
            $language->urls()->delete();
        });
    }

    /**
     * Handle the Language "forceDeleted" event.
     * @param Language $language
     *
     * @return void
     */
    public function forceDeleted(Language $language): void
    {
        //
    }

    /**
     * Ensures that only one default language exists.
     * @param Language $savedLanguage
     *
     * @return void
     */
    protected function ensureOnlyOneDefault(Language $savedLanguage): void
    {
        if ($savedLanguage->default) {
            Language::withoutEvents(function () use ($savedLanguage) {
                Language::default(true)->where('id', '!=', $savedLanguage->id)->update([
                    'default' => false,
                ]);
            });
        }
    }
}
