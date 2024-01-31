<div>
    <form method="post" action="" wire:submit.prevent="create">
        @csrf
        <x-fields.group label="{{ __('admin.attribute_groups.name') }}" hint="{{ __('admin.form.required') }}"
            for="group_name" required :error="$errors->first('attribute_name.' . $this->defaultLanguage->code)">
            <x-fields.translatable>
                <x-fields.text autocomplete="off" wire:model.defer="attribute_name.{{ $this->defaultLanguage->code }}"
                    wire:loading.attr="disabled" :error="$errors->first('attribute_name.' . $this->defaultLanguage->code)"
                    placeholder="{{ __('admin.attribute_groups.name_instruction') }}" />
                @foreach ($this->languages->filter(fn($lang) => !$lang->default) as $language)
                    <x-slot :name="$language->code">
                        <x-fields.text autocomplete="off" wire:model.defer="attribute_name.{{ $language->code }}"
                            wire:loading.attr="disabled" :error="$errors->first('attribute_name.' . $language->code)" />

                    </x-slot>
                @endforeach
            </x-fields.translatable>
        </x-fields.group>

        @if ($errors->has('attributeGroup.handle'))
            <div class="bg-error bg-opacity-10 p-4 rounded-md mb-6 text-center text-sm text-error">
                {{ __('admin.attribute_groups.unique') }}
            </div>
        @endif

        <div class="flex justify-between items-center space-x-4">
            <x-button label="{{ __('admin.form.save') }}" type="submit" class="btn-primary" spinner="create" />
        </div>
    </form>
</div>
