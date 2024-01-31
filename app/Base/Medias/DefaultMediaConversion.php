<?php

namespace App\Base\Medias;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;

final class DefaultMediaConversion
{
    public function apply(Model $model): void
    {
        $conversions = [
            'zoom' => [
                'width' => 1000,
                'height' => 1000,
            ],
            'large' => [
                'width' => 800,
                'height' => 800,
            ],
            'medium' => [
                'width' => 500,
                'height' => 500,
            ],
            'small' => [
                'width' => 300,
                'height' => 300,
            ],
        ];

        foreach ($conversions as $key => $conversion) {
            $model->addMediaConversion($key)
                ->fit(
                    Manipulations::FIT_MAX,
                    $conversion['width'],
                    $conversion['height']
                )
                ->optimize()
                ->keepOriginalImageFormat();
        }
    }
}
