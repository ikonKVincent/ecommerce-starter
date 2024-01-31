<?php

namespace App\Base;

use App\Models\Pages\Page;
use App\Models\Settings\Attribute;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AttributeManifest
{
    /**
     * A collection of available attribute types.
     */
    protected Collection $types;

    protected Collection $searchableAttributes;

    protected $baseTypes = [
        Page::class,
    ];

    /**
     * Initialise the class.
     */
    public function __construct()
    {
        $this->types = collect();
        $this->searchableAttributes = collect();

        foreach ($this->baseTypes as $type) {
            $this->addType($type);
        }
    }

    public function addType($type, $key = null)
    {
        $this->types->prepend(
            $type,
            $key ?: Str::lower(
                class_basename($type)
            )
        );
    }

    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function getType($key)
    {
        $type = null;
        foreach ($this->types as $t => $type) {
            if ($type == $key) {
                $type = $this->types[$t];
                break;
            }
        }
        return $type;
    }

    public function getSearchableAttributes(string $attributeType)
    {
        $attributes = $this->searchableAttributes->get($attributeType, null);

        if ($attributes) {
            return $attributes;
        }

        $attributes = Attribute::whereAttributeType($attributeType)
            ->whereSearchable(true)
            ->get();

        $this->searchableAttributes->put(
            $attributeType,
            $attributes
        );

        return $attributes;
    }
}
