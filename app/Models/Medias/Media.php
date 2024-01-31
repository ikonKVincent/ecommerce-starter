<?php

namespace App\Models\Medias;

use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

final class Media extends BaseMedia
{
    use QueryCacheable;

    public int $cacheFor = 86400;

    public string $cachePrefix = 'medias_';

    protected static bool $flushCacheOnUpdate = true;
}
