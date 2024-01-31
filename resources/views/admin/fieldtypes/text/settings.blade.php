<x-fields.group
    label="{{ __('admin.fieldtypes.text.richtext') }}"
    for="attribute_configuration.richtext"
    :error="$errors->first('attribute_configuration.richtext')"
>
    <x-fields.boolean
        id="attribute_configuration.richtext"
        name="attribute_configuration.richtext"
        value="1"
        wire:model.defer="attribute_configuration.richtext"
        wire:loading.attr="disabled"
        :error="$errors->first('attribute_configuration.richtext')"
    />
</x-fields.group>
