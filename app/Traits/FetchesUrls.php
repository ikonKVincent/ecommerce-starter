<?php

namespace App\Traits;

use App\Models\Settings\Url;

trait FetchesUrls
{
    /**
     * The URL model from the slug.
     */
    public ?Url $url = null;

    /**
     * Fetch a url model.
     * @param string $slug
     * @param string $type
     * @param array $eagerLoad
     *
     * @return Url|null
     */
    public function fetchUrl(string $slug, string $type, array $eagerLoad = []): ?Url
    {
        return Url::whereEntityType($type)
            ->whereSlug($slug)
            ->with($eagerLoad)
            ->orderBy('created_at', 'desc')
            ->first();
    }
    /**
     * Fetch a old url model.
     * @param string $slug
     * @param string $type
     *
     * @return Url|null
     */
    public function oldUrl(string $slug, string $type): ?Url
    {
        return Url::whereEntityType($type)
            ->whereOldSlug($slug)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
