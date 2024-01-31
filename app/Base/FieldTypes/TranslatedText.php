<?php

namespace App\Base\FieldTypes;

use App\Exceptions\FieldTypeException;
use App\Interfaces\FieldType;
use Illuminate\Database\Eloquent\Collection;
use JsonSerializable;

class TranslatedText implements FieldType, JsonSerializable
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $value;

    /**
     * Create a new instance of TranslatedText field type.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $value
     */
    public function __construct($value = null)
    {
        if ($value) {
            $this->setValue($value);
        } else {
            $this->value = new Collection();
        }
    }

    /**
     * Serialize the class.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    /**
     * Return the value of this field.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of this field.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $value
     */
    public function setValue($value)
    {
        if (is_array($value)) {
            $value = collect($value);
        }

        if (!$value instanceof \Illuminate\Support\Collection) {
            throw new FieldTypeException(self::class . ' value must be a collection.');
        }

        foreach ($value as $key => $item) {
            if (is_string($item) || is_numeric($item) || is_bool($item)) {
                $item = new Text($item);
                $value[$key] = $item;
            }
            if ($item && (get_class($item) !== Text::class)) {
                throw new FieldTypeException(self::class . ' only supports ' . Text::class . ' field types.');
            }
        }

        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel(): string
    {
        return "Text multilangue";
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsView(): string
    {
        return 'admin.fieldTypes.translated-text.settings';
    }

    /**
     * {@inheritDoc}
     */
    public function getView(): string
    {
        return 'admin.fieldTypes.translated-text.view';
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
