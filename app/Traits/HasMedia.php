<?php

namespace App\Traits;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMedia
{
    use InteractsWithMedia;

    protected array $conversionClasses;

    /**
     * Set Media Conversions
     */
    public function registerMediaCollections(): void
    {
        $fallbackUrl = config('akawam.media.fallback.url');
        $fallbackPath = config('akawam.media.fallback.path');

        $collection = $this->addMediaCollection('images');

        if ($fallbackUrl) {
            $collection = $collection->useFallbackUrl($fallbackUrl);
        }

        if ($fallbackPath) {
            $collection = $collection->useFallbackPath($fallbackPath);
        }
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $conversionClasses = $this->setConversionClasses();
        if (!empty($conversionClasses)) {
            foreach ($conversionClasses as $classname) {
                app($classname)->apply($this);
            }
        }
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 50, 50)
            ->sharpen(10)
            ->optimize()
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    protected function setConversionClasses(): array
    {
        return config('akawam.media.conversions', []);
    }
}
