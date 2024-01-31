<?php

namespace App\Models\Pages;

use App\Base\Model;
use App\Models\Settings\Attribute;
use App\Traits\HasAttributes;
use Database\Factories\PageTypeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class PageType extends Model
{
    use HasAttributes,
        HasFactory,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'page_type_';

    public $incrementing = false;

    protected $fillable = [
        'name',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Get the mapped attributes relation.
     */
    public function mappedAttributes(): MorphToMany
    {
        $prefix = config('akawam.database.table_prefix');

        return $this->morphToMany(
            Attribute::class,
            'attributable',
            "{$prefix}attributables"
        )->withTimestamps();
    }

    /**
     * Return the product attributes relationship.
     */
    public function pageAttributes(): MorphToMany
    {
        return $this->mappedAttributes()->whereAttributeType(Page::class);
    }

    /**
     * Return the pages relationship.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): PageTypeFactory
    {
        return PageTypeFactory::new();
    }
}
