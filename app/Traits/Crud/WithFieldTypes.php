<?php

namespace App\Traits\Crud;

use Illuminate\Support\Collection;
use App\Base\FieldTypes\File;
use App\Base\FieldTypes\Number;
use App\Base\FieldTypes\Text;
use App\Base\FieldTypes\TranslatedText;

trait WithFieldTypes
{
    /**
     * Get Fields Types
     */
    protected function getFieldTypesProperty(): Collection
    {
        $fieldTypes = collect([
            Text::class,
            TranslatedText::class,
            File::class,
            Number::class,
        ]);

        return $fieldTypes->map(fn ($type) => app()->make($type));
    }
}
