<textarea
    {{ $attributes->merge([
            'cols' => '0',
            'rows' => '0',
            'class' => 'form-control w-full',
        ])->class([
            'form-control--error border-error' => !!$error,
        ]) }}>{{ $value }}</textarea>
