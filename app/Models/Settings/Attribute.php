<?php

namespace App\Models\Settings;

use App\Base\Model;
use App\Facades\DB;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Attribute extends Model
{
    use HasFactory,
        HasTranslations,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'attribute_';

    public $incrementing = false;

    protected $casts = [
        'name' => AsCollection::class,
        'configuration' => AsCollection::class,
        'required' => 'boolean',
        'filterable' => 'boolean',
        'searchable' => 'boolean',
        'system' => 'boolean',
    ];

    protected $fillable = [
        'attribute_type',
        'attribute_group_id',
        'name',
        'handle',
        'section',
        'type',
        'required',
        'default_value',
        'configuration',
        'validation_rules',
        'system',
        'filterable',
        'searchable',
        'position',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    protected $translates = [
        'name',
    ];

    public static function boot()
    {
        static::deleting(function (Model $model) {
            DB::table(
                config('akawam.database.table_prefix') . 'attributables'
            )->where('attribute_id', '=', $model->id)->delete();
        });
        parent::boot();
    }

    /**
     * Return the attributable relation.
     */
    public function attributable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Returns the attribute group relation.
     */
    public function attributeGroup(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    /**
     * Apply the system scope to the query builder.
     *
     * @param  Builder  $query
     * @param  string  $type
     * @return Builder
     */
    public function scopeSystem(Builder $query, string $type): Builder
    {
        return $query->where('attribute_type', $type)->where('system', true);
    }

    // TODO : Create Factory
}
