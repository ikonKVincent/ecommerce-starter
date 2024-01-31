<?php

namespace App\Base;

interface FieldType
{
    /**
     * Return the config for the field type.
     */
    public function getConfig(): array;

    /**
     * Return the display label for the field type.
     */
    public function getLabel(): string;

    /**
     * Return the reference to the view used in the settings.
     */
    public function getSettingsView(): string;

    /**
     * Return the field type value.
     */
    public function getValue(): mixed;

    /**
     * Return the view used in editing.
     */
    public function getView(): string;

    /**
     * Set the value for the field type.
     *
     * @param  mixed  $value
     */
    public function setValue($value): void;
}
