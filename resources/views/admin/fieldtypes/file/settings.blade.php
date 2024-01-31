<x-fields.group
        label="{{ __('admin.fieldtypes.file.max_files') }}"
        for="attribute_configuration.max_files"
        instructions="{{ __('admin.fieldtypes.file.max_files_instruction') }}"
        :error="$errors->first('attribute_configuration.max_files')"
    >
        <x-fields.text
            type="number"
            name="attribute_configuration.max_files"
            wire:model.defer="attribute_configuration.max_files"
            wire:loading.attr="disabled"
            :error="$errors->first('attribute_configuration.max_files')"
        />
    </x-fields.group>
