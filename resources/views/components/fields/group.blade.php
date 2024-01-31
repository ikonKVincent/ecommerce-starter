<div class="form-group">
    {{-- Label --}}
    <x-fields.label for="{{ $for }}" label="{{ $label }}" required="{{ $required }}" />
    {{-- Field --}}
    <div class="relative mt-1">
        {{ $slot }}
    </div>
    {{-- Instruction --}}
    @if ($hint)
        <div class="label-text-alt text-gray-400 p-1 pb-0 italic">
            {!! render_content($hint) !!}
        </div>
    @endif
    {{-- Error --}}
    <x-alerts.error :error="$error" :errors="$errors" />
</div>
