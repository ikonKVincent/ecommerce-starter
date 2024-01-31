<?php

namespace App\Base\FieldTypes;

use App\Interfaces\FieldType;
use JsonSerializable;

class File implements FieldType, JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

    /**
     * The config to use.
     */
    protected array $config = [];

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
     * Create a new instance of File field type.
     *
     * @param  string  $value
     */
    public function __construct($value = '')
    {
        $this->setValue($value);
    }

    /**
     * Returns the value when accessed as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }

    /**
     * Return the value of this field.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of this field.
     *
     * @param  string  $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return "Fichier";
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsView(): string
    {
        return 'admin.fieldTypes.file.settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getView(): string
    {
        return 'admin.fieldTypes.file.view';
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return [
            'options' => [
                'max_files' => 'numeric',
            ],
        ];
    }
}
