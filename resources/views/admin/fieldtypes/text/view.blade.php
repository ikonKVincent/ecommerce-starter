<div>
    @php
        $field_value = null;
        if(isset($language)) {
            if(old($field['signature'].'.'.$language)) {
                $field_value = $field['signature'].'.'.$language;
            }
            if(isset($field['data'][$language]) && $field['data'][$language]) {
                $field_value = $field['data'][$language]->getValue();
            }
        } else {
            if(old($field['signature'])) {
                $field_value = $field['signature'];
            }
            if(isset($field['data']) && $field['data']) {
                $field_value = $field['data']->getValue();
            }
        }
    @endphp
    @if(($field['configuration']['richtext'] ?? false))
        <x-fields.rich-text
            id="{{ $field['signature'] }}{{ isset($language) ? '.' . $language : null }}"
            name="attributes[{{ $field['signature'] }}]{{ isset($language) ? '[' . $language . ']' : null }}"
            :value="$field_value"
            :error="$errors->first($field['signature'] . isset($language) ? '.' . $language : null )"
        />
    @else
        <x-fields.text
            id="{{ $field['signature'] }}{{ isset($language) ? '.' . $language : null }}"
            name="attributes[{{ $field['signature'] }}]{{ isset($language) ? '[' . $language . ']' : null }}"
            value="{{ $field_value }}"
            :error="$errors->first($field['signature'] . isset($language) ? '.' . $language : null )"
        />
    @endif
</div>
