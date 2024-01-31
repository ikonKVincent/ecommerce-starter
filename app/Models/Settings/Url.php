<?php

namespace App\Models\Settings;

use App\Base\Model;
use Database\Factories\UrlFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Url extends Model
{
    use HasFactory,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'url_';

    public $incrementing = false;

    protected $casts = [
        'default' => 'boolean',
    ];

    protected $fillable = [
        'default',
        'language_id',
        'element_type',
        'element_id',
        'slug',
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

    /**
     * Return the language relationship.
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Return the query scope for default.
     */
    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('default', true);
    }

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): UrlFactory
    {
        return UrlFactory::new();
    }
}
