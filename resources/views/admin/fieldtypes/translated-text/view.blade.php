<div>
    <x-fields.translatable>
        @include("admin.fieldtypes.text.view", [
            'language' => $defaultLanguage->code,
            'field' => $field,
        ])
        @foreach($languages->filter(fn ($lang) => !$lang->default) as $language)
            <x-slot :name="$language['code']">
                @include("admin.fieldtypes.text.view", [
                    'language' => $language->code,
                    'field' => $field,
                ])
            </x-slot>
        @endforeach
    </x-fields.translatable>
</div>
