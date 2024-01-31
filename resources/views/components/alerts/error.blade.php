<div>
    @if ($error)
        <div class="flex items-center gap-1">
            @if ($errorIcon)
                <x-icon name="o-exclamation-circle" class="text-error w-4 h-4" />
            @endif
            <p class="text-sm text-error">{{ $error }}</p>
        </div>
    @endif

    @if (count($errors))
        <div class="space-y-1">
            @foreach ($errors as $error)
                @if (is_array($error))
                    @foreach ($error as $text)
                        <p class="text-sm text-error">{{ $text }}</p>
                    @endforeach
                @else
                    <p class="text-sm text-error">{{ $error }}</p>
                @endif
            @endforeach
        </div>
    @endif
</div>
