@if($data->getFirstMedia($image))
    <button class="modal-img-btn rounded-full overflow-hidden border border-accent"
        aria-controls="modal-image-name"
        aria-label="Cliquez pour agrandir">
        <img class="block w-14"
            src="{{ $data->getFirstMedia($image)->getUrl('thumb') }}"
            alt="{{ $data->getFirstMedia($image)->name }}"
            data-src="{{ $data->getFirstMedia($image)->getUrl(isset($conversion)?$conversion:'large') }}"
            loading="lazy"
        >
        <span class="modal-img-btn__icon-wrapper" aria-hidden="true">
            <svg class="icon w-[24px] h-[24px]" viewBox="0 0 24 24">
                <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" fill="none" stroke="currentColor" stroke-miterlimit="10">
                    <path d="M1.373,13.183a2.064,2.064,0,0,1,0-2.366C2.946,8.59,6.819,4,12,4s9.054,4.59,10.627,6.817a2.064,2.064,0,0,1,0,2.366C21.054,15.41,17.181,20,12,20S2.946,15.41,1.373,13.183Z"></path>
                    <circle cx="12" cy="12" r="4"></circle>
                </g>
            </svg>
        </span>
    </button>
@else
    <span class="block w-12 h-12 rounded-full overflow-hidden border border-accent">
        <img class="object-fit object-cover w-full h-full" src="/images/lazy-load-placeholder.svg" alt="" loading="lazy">
    </span>
@endif
