<div class="alert alert-error bg-opacity-60  text-black rounded-md p-4 absolute text-[0.9375rem] [&.alert--is-visible]:static js-alert mb-4"
    role="alert">
    <div class="flex items-center justify-between">
        <div class="flex items-start gap-5">
            <svg class="h-6 w-6  mt-2 text-error icon" viewBox="0 0 24 24" aria-hidden="true">
                <g fill="currentColor">
                    <circle cx="12" cy="12" r="12" fill-opacity=".2"></circle>
                    <path d="M12 15a1 1 0 0 1-1-1V5a1 1 0 0 1 2 0v9a1 1 0 0 1-1 1z"></path>
                    <circle cx="12" cy="18.5" r="1.5"></circle>
                </g>
            </svg>
            <div class="">
                <h4>Attention !</h4>
                <ul class="list-decimal">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
