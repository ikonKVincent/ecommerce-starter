<div class="switch{{ $disabled ? ' cursor-not-allowed opacity-30' : '' }}">
    <input id="{{ $id }}"
        {{ $attributes->merge([
            'type' => 'checkbox',
            'class' => 'switch__input',
        ]) }}{{ $disabled ? ' disabled' : '' }}{{ $checked ? ' checked' : '' }}>
    <label class="switch__label" for="{{ $id }}" aria-hidden="true">{{ $id }}</label>
    <div class="switch__marker" aria-hidden="true"></div>
</div>
