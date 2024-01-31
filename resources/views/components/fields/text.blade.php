<input
    {{ $attributes->merge([
            'type' => 'text',
            'class' => 'form-control w-full text-sm',
        ])->class([
            'form-control--error border-error' => !!$error,
        ]) }}>
