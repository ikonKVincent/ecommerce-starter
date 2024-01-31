<?php

namespace App\Models\Medias;

use App\Base\Model;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia as MediaLibraryHasMedia;

class Asset extends Model implements MediaLibraryHasMedia
{
    use HasFactory,
        HasMedia,
        HasUlids,
        QueryCacheable;

    /**
     * Define which attributes should be
     * protected from mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the associated file.
     *
     * @return MorphOne
     */
    public function file(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }
}
