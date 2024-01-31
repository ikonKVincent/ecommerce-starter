<?php

return [
    'conversions' => [
        App\Base\Medias\DefaultMediaConversion::class,
    ],
    'fallback' => [
        'url' => env('FALLBACK_IMAGE_URL', null),
        'path' => env('FALLBACK_IMAGE_PATH', null),
    ],
];
