<?php

namespace App\Models\Settings;

use App\Base\Model;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Seo extends Model
{
    use HasFactory,
        HasTranslations,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'seo_';

    public $incrementing = false;

    protected $casts = [
        'robot' => 'boolean',
        'title' => AsCollection::class,
        'description' => AsCollection::class,
    ];

    protected $fillable = [
        'robot',
        'title',
        'description',
        'type',
        'element_type',
        'element_id',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Return the element relationship.
     */
    public function element(): MorphTo
    {
        return $this->morphTo();
    }
}
