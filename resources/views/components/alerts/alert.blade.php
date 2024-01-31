<div class="alert alert-{{ $type }} bg-opacity-60 text-black p-4 text-[0.9375rem] [&.alert--is-visible]:static js-alert mb-4"
    role="alert">
    <div class="flex items-center justify-between">
        <div class="flex items-start gap-5">
            @if ($type == 'error')
                <svg class="h-6 w-6 text-{{ $type }} icon" viewBox="0 0 24 24" aria-hidden="true">
                    <g fill="currentColor">
                        <circle cx="12" cy="12" r="12" fill-opacity=".2"></circle>
                        <path d="M12 15a1 1 0 0 1-1-1V5a1 1 0 0 1 2 0v9a1 1 0 0 1-1 1z"></path>
                        <circle cx="12" cy="18.5" r="1.5"></circle>
                    </g>
                </svg>
            @else
                <svg class="h-6 w-6 text-{{ $type }} icon" viewBox="0 0 24 24" aria-hidden="true">
                    <g fill="black">
                        <circle cx="12" cy="12" r="12" opacity=".2" style="isolation:isolate"></circle>
                        <path
                            d="M9.5 17a1 1 0 0 1-.707-.293l-3-3a1 1 0 0 1 1.414-1.414L9.5 14.586l7.293-7.293a1 1 0 1 1 1.439 1.389l-.025.025-8 8A1 1 0 0 1 9.5 17z">
                        </path>
                    </g>
                </svg>
            @endif
            <div class="text-component">
                <p>{!! Session::get($type) !!}</p>
            </div>
        </div>
    </div>
</div>
