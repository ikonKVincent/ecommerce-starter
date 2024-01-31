<?php

namespace App\Models\Settings;

use App\Base\Model;
use App\Traits\HasDefaultRecord;
use App\Traits\HasMacros;
use Database\Factories\LanguageFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Language extends Model
{
    use HasDefaultRecord,
        HasFactory,
        HasMacros,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'language_';

    public $incrementing = false;

    protected $casts = [
        'default' => 'boolean',
    ];

    protected $fillable = [
        'default',
        'code',
        'name',
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Return the URLs relationship
     */
    public function urls(): HasMany
    {
        return $this->hasMany(Url::class);
    }

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): LanguageFactory
    {
        return LanguageFactory::new();
    }
}
