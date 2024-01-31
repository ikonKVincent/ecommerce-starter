<?php

namespace App\Base\Medias;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;

final class AvatarMediaConversion
{
    public function apply(Model $model): void
    {
        $model->addMediaConversion('avatar')
            ->crop(Manipulations::CROP_CENTER, 250, 250)
            ->optimize()
            ->keepOriginalImageFormat();
    }
}
