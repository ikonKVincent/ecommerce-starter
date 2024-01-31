<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use App\Base\FieldType;

trait HasTranslations
{
    protected ?string $translationLocale = null;

    /**
     * Shorthand to translate an attribute.
     */
    public function attr(...$params)
    {
        return $this->translateAttribute(...$params);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function getAttributeValue($key): mixed
    {
        if (!$this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->translate($key, $this->getLocale());
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->translationLocale ?: config('app.locale');
    }

    /**
     * @return array
     */
    public function getTranslatableAttributes(): array
    {
        return is_array($this->translates)
            ? $this->translates
            : [];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes());
    }

    /**
     * Translate a given attribute based on passed locale.
     * @param string $attribute
     * @param string|null $locale
     *
     * @return string|null
     */
    public function translate(string $attribute, ?string $locale = null): ?string
    {
        $values = json_decode($this->attributes[$attribute] ?? '' ?: '{}', true) ?: [];

        if (is_string($values)) {
            return $values;
        }

        if (!$values) {
            return null;
        }

        $locale = $locale ?: app()->getLocale();
        $value = Arr::accessible($values) ?
            Arr::get($values, $locale) :
            get_object_vars($values)[$locale] ?? null;

        return $value ?: Arr::get(
            $values,
            app()->getLocale(),
            Arr::first($values)
        );
    }

    /**
     * Translate a value from attribute data.
     * @param string $attribute
     * @param string|null $locale
     *
     * @return string|null
     */
    public function translateAttribute(string $attribute, ?string $locale = null): ?string
    {
        $field = Arr::get($this->getAttribute('attribute_data'), $attribute);
        if (!$field) {
            return null;
        }
        $translations = $field->getValue();

        if (!is_iterable($translations) || !$translations) {
            return $translations;
        }
        $value = Arr::get($translations, $locale ?: app()->getLocale(), Arr::first($translations));

        if (!$value) {
            return null;
        }
        if (!$value instanceof FieldType) {
            return $field->getValue();
        }

        return $value ? $value->getValue() : null;
    }
}
