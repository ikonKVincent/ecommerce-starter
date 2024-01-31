<?php

namespace App\Models\Pages;

use App\Base\Model;
use App\Casts\AsAttributeData;
use App\Traits\HasMedia;
use App\Traits\HasPublished;
use App\Traits\HasSeo;
use App\Traits\HasUrls;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia as MediaLibraryHasMedia;

class Page extends Model implements MediaLibraryHasMedia
{
    use HasFactory,
        HasMedia,
        HasPublished,
        HasSeo,
        HasUrls,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'page_';

    public $incrementing = false;

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'name' => AsCollection::class,
        'attribute_data' => AsAttributeData::class,
    ];

    protected $fillable = [
        'is_published',
        'published_at',
        'page_type_id',
        'name',
        'attribute_data',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Return the page type relationship.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(PageType::class, 'page_type_id', 'id');
    }
}
