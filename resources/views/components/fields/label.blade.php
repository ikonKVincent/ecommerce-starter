<label for="{{ $for }}" class="pt-0 label label-text font-semibold">
    <span>
        {!! strip_tags($label) !!}
        @if ($required)
            <span class="text-error">&#42;</span>
        @endif
    </span>
</label>
