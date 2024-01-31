<div>
    @if ($system)
        <div class="bg-error bg-opacity-10 p-4 rounded-md mb-6 text-center text-sm text-error">
            Cet attribut est protégé car indispensable au bon fonctionnement du site.
        </div>
    @endif
    <form method="post" action="" wire:submit.prevent="save">
        {{-- Name --}}
        <x-fields.group label="{{ __('admin.attributes.name') }}" hint="{{ __('admin.form.required') }}"
            for="attribute_name" required :error="$errors->first('attribute_name.' . $this->defaultLanguage->code)">
            <x-fields.translatable>
                <x-fields.text autocomplete="off" wire:model.defer="attribute_name.{{ $this->defaultLanguage->code }}"
                    wire:loading.attr="disabled" wire:change="formatHandle" :error="$errors->first('attribute_name.' . $this->defaultLanguage->code)" />
                @foreach ($this->languages->filter(fn($lang) => !$lang->default) as $language)
                    <x-slot :name="$language->code">
                        <x-fields.text autocomplete="off" wire:model.defer="attribute_name.{{ $language->code }}"
                            wire:loading.attr="disabled" :error="$errors->first('attribute_name.' . $language->code)" />

                    </x-slot>
                @endforeach
            </x-fields.translatable>
        </x-fields.group>
        {{-- Handle --}}
        <x-fields.group label="{{ __('admin.attributes.handle') }}" hint="{{ __('admin.form.required') }}"
            for="handle" required :error="$errors->first('handle')">
            <x-fields.text autocomplete="off" wire:model.defer="handle" wire:loading.attr="disabled" :error="$errors->first('handle')"
                :disabled="$system" />
        </x-fields.group>
        {{-- Required --}}
        <x-fields.group label="{{ __('admin.form.required') }}" for="required" :error="$errors->first('required')"
            hint="Cet attribut est-il obligatoire lors de l'édition/création ?">
            <x-fields.boolean id="required" wire:model.defer="required" checked="{{ $required ? true : false }}"
                value="1" :error="$errors->first('required')" :disabled="$system" />
        </x-fields.group>
        {{-- Validation --}}
        <x-fields.group label="{{ __('admin.attributes.validation_rule') }}"
            hint="{{ __('admin.attributes.validation_instruction') }}" for="validation_rules" :error="$errors->first('validation_rules')">
            <x-fields.text autocomplete="off" wire:model.defer="validation_rules" wire:loading.attr="disabled"
                :error="$errors->first('validation_rules')" :disabled="$system" />
        </x-fields.group>
        {{-- Type --}}
        <x-fields.group label="{!! __('admin.attributes.attribute_type') !!}" for="attribute_type" :error="$errors->first('attribute_type')" required>
            <x-fields.select id="attribute_type" name="attribute_type" wire:model.live="attribute_type"
                :error="$errors->first('attribute_type')" :disabled="$system">
                @foreach ($this->fieldTypes as $fieldType)
                    <option value="{{ get_class($fieldType) }}">{{ $fieldType->getLabel() }}</option>
                @endforeach
            </x-fields.select>
        </x-fields.group>
        @if ($this->getFieldType()->getSettingsView())
            <div wire:key="{{ get_class($this->getFieldType()) }}">
                @include($this->getFieldType()->getSettingsView())
            </div>
        @endif
        <div class="flex justify-between items-center space-x-4">
            <x-button label="{{ __('admin.form.save') }}" type="submit" class="btn-primary" spinner="save" />
        </div>
    </form>
</div>
