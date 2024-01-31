<?php

namespace App\Observers\Settings;

use App\Models\Settings\Url;

class UrlObserver
{
    /**
     * Handle the Url "created" event.
     *
     * @param Url $url
     *
     * @return void
     */
    public function created(Url $url): void
    {
        $this->ensureOnlyOneDefault($url);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param Url $url
     *
     * @return void
     */
    public function updated(Url $url): void
    {
        $this->ensureOnlyOneDefault($url);
    }

    /**
     * Handle the Url "deleted" event.
     *
     * @param Url $url
     *
     * @return void
     */
    public function deleted(Url $url): void
    {
        if ($url->default) {
            $url = Url::default(false)
                ->where('id', '!=', $url->id)
                ->where('element_type', $url->element_type)
                ->where('element_id', $url->element_id)
                ->where('language_id', $url->language_id)
                ->first();

            if ($url) {
                $url->default = true;
                $url->saveQuietly();
            }
        }
    }

    /**
     * Ensures that only one default channel exists.
     *
     * @param  Url  $savedUrl  The url that was just saved.
     *
     * @return void
     */
    protected function ensureOnlyOneDefault(Url $savedUrl): void
    {
        // Wrap here so we avoid a query if it's not been set to default.
        if ($savedUrl->default) {
            $url = Url::default(true)
                ->where('id', '!=', $savedUrl->id)
                ->where('element_type', $savedUrl->element_type)
                ->where('element_id', $savedUrl->element_id)
                ->where('language_id', $savedUrl->language_id)
                ->first();

            if ($url) {
                $url->default = false;
                $url->saveQuietly();
            }
        }
    }
}
