<?php

namespace App\Base;

use App\Exceptions\FieldTypes\FieldTypeMissingException;
use App\Exceptions\FieldTypes\InvalidFieldTypeException;
use App\Base\FieldTypes\Dropdown;
use App\Base\FieldTypes\File;
use App\Base\FieldTypes\ListField;
use App\Base\FieldTypes\Number;
use App\Base\FieldTypes\Text;
use App\Base\FieldTypes\Toggle;
use App\Base\FieldTypes\TranslatedText;
use App\Base\FieldTypes\YouTube;

class FieldTypeManifest
{
    /**
     * The FieldTypes available.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $fieldTypes;

    public function __construct()
    {
        $this->fieldTypes = collect([
            Dropdown::class,
            ListField::class,
            Number::class,
            Text::class,
            Toggle::class,
            TranslatedText::class,
            YouTube::class,
            File::class,
        ]);
    }

    /**
     * Add a FieldType.
     *
     * @param  string  $classname
     * @return void
     */
    public function add($classname)
    {
        if (!class_exists($classname)) {
            throw new FieldTypeMissingException($classname);
        }

        if (!(app()->make($classname) instanceof FieldType)) {
            throw new InvalidFieldTypeException($classname);
        }

        $this->fieldTypes->push($classname);
    }

    /**
     * Return the fieldtypes.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTypes()
    {
        return $this->fieldTypes->map(fn ($type) => app()->make($type));
    }
}
