<?php

namespace App\Models\Settings;

use App\Base\Model;
use App\Traits\HasTranslations;
use Database\Factories\AttributeGroupFactory;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AttributeGroup extends Model
{
    use HasFactory,
        HasTranslations,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'attribute_group_';

    public $incrementing = false;

    protected $casts = [
        'name' => AsCollection::class,
    ];

    protected $fillable = [
        'attributable_type',
        'name',
        'handle',
        'position',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    protected $translates = [
        'name',
    ];

    protected $with = ['attributes'];


    /**
     * Return the attributes relationship.
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class)->orderBy('position');
    }

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): AttributeGroupFactory
    {
        return AttributeGroupFactory::new();
    }
}
