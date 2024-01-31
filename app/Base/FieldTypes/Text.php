<?php

namespace App\Base\FieldTypes;

use App\Exceptions\FieldTypeException;
use App\Interfaces\FieldType;
use JsonSerializable;

class Text implements FieldType, JsonSerializable
{
    /**
     * @var string
     */
    protected $value;

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
     * Create a new instance of Text field type.
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
        return $this->getValue() ?? '';
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
        if ($value && (!is_string($value) && !is_numeric($value) && !is_bool($value))) {
            throw new FieldTypeException(self::class . ' value must be a string.');
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return "Texte";
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsView(): string
    {
        return 'admin.fieldTypes.text.settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getView(): string
    {
        return 'admin.fieldTypes.text.view';
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig(): array
    {
        return [
            'options' => [
                'richtext' => 'nullable',
                'options' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (!json_decode($value, true)) {
                            $fail('Must be valid json');
                        }
                    },
                ],
            ],
        ];
    }
}
