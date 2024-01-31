<div class="select-field">
    <select
        {{ $attributes->merge([
                'type' => 'text',
                'class' => 'select select__input appearance-none form-control w-full text-sm',
            ])->class([
                'form-control--error border-error' => !!$error,
            ]) }}>
        {{ $slot }}
    </select>
    <svg class="icon inline-block text-inherit fill-current leading-none shrink-0 select__icon" aria-hidden="true"
        viewBox="0 0 16 16">
        <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" />
    </svg>
</div>
