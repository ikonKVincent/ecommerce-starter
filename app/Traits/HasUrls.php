<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Settings\Url;

trait HasUrls
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasUrls()
    {
        static::created(function (Model $model) {
            $generator = config('akawam.urls.generator', null);
            if ($generator) {
                app($generator)->handle($model);
            }
        });

        static::deleted(function (Model $model) {
            if (!$model->deleted_at) {
                $model->urls()->delete();
            }
        });
    }

    /**
     * Get all of the models URLs.
     * @return MorphMany
     */
    public function urls(): MorphMany
    {
        return $this->morphMany(
            Url::class,
            'element'
        );
    }

    /**
     * get the default URL
     * @return MorphOne
     */
    public function defaultUrl(): MorphOne
    {
        return $this->morphOne(
            Url::class,
            'element'
        )->default(true);
    }
}
