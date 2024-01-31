<?php

namespace App\Base\FieldTypes;

use App\Exceptions\FieldTypeException;
use App\Interfaces\FieldType;
use JsonSerializable;

class ListField implements FieldType, JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Create a new instance of List field type.
     *
     * @param  int|float  $value
     */
    public function __construct($value = [])
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
     * @return array
     */
    public function getValue()
    {
        return json_decode($this->value ?? '[]');
    }

    /**
     * Set the value of this field.
     *
     * @param  int|float  $value
     */
    public function setValue($value)
    {
        if (!is_array($value)) {
            throw new FieldTypeException(self::class . ' value must be an array.');
        }

        $this->value = json_encode($value);
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return "Liste";
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsView(): string
    {
        return 'admin.fieldTypes.list-field.settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getView(): string
    {
        return 'admin.fieldTypes.list-field.view';
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return [
            'options' => [
                'max_items' => 'numeric|nullable',
            ],
        ];
    }
}
