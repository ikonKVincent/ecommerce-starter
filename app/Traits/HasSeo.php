<?php

namespace App\Traits;

use App\Models\Settings\Seo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeo
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasSeo()
    {
        static::deleted(function (Model $model) {
            if (!$model->deleted_at) {
                $model->seo->delete();
            }
        });
    }

    /**
     * Get the Seo of Model
     * @return MorphOne
     */
    public function defaultUrl(): MorphOne
    {
        return $this->morphOne(
            Seo::class,
            'element'
        );
    }
}
