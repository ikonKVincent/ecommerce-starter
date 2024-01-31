<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Base\FieldTypeManifestInterface;

class FieldTypeManifest extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return FieldTypeManifestInterface::class;
    }
}
