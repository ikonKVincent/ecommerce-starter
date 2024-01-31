<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-fields.group
        label="{{ __('admin.fieldtypes.number.min') }}"
        for="attribute_configuration.min"
        :error="$errors->first('attribute_configuration.min')"
    >
        <x-fields.text
            type="number"
            name="attribute_configuration.min"
            wire:model.defer="attribute_configuration.min"
            wire:loading.attr="disabled"
            :error="$errors->first('attribute_configuration.min')"
        />
    </x-fields.group>
    <x-fields.group
        label="{{ __('admin.fieldtypes.number.max') }}"
        for="attribute_configuration.max"
        :error="$errors->first('attribute_configuration.max')"
    >
    <x-fields.text
            type="number"
            name="attribute_configuration.max"
            wire:model.defer="attribute_configuration.max"
            wire:loading.attr="disabled"
            :error="$errors->first('attribute_configuration.max')"
        />
    </x-fields.group>
</div>
