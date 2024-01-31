<?php

namespace App\Base\FieldTypes;

use App\Exceptions\FieldTypeException;
use App\Interfaces\FieldType;
use JsonSerializable;

class Dropdown implements FieldType, JsonSerializable
{
    /**
     * @var string|int
     */
    protected $value;

    /**
     * Create a new instance of List field type.
     *
     * @param  string|int  $value
     */
    public function __construct($value = '')
    {
        $this->setValue($value);
    }

    /**
     * Serialize the class.
     *
     * @return string
     */
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    /**
     * Return the value of this field.
     *
     * @return string|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of this field.
     *
     * @param  string|int  $value
     */
    public function setValue($value)
    {
        if ($value && !is_string($value)) {
            throw new FieldTypeException(self::class . ' value must be a string.');
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return "Menu déroulant";
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsView(): string
    {
        return 'admin.fieldTypes.dropdown.settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getView(): string
    {
        return 'admin.fieldTypes.dropdown.view';
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return [
            'options' => [
                'lookups' => 'array',
                'lookups.*.label' => 'string|required',
                'lookups.*.value' => 'nullable|string',
            ],
        ];
    }
}
