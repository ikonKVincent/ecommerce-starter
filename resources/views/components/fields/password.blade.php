<div class="password">
    <input
        {{ $attributes->merge([
                'type' => 'password',
                'class' => 'password__input form-control w-full',
            ])->class([
                'form-control--error border-error' => !!$error,
            ]) }} />
    <div class="password__btn">
        <span class="password__btn-label hidden-password" aria-label="{{ __('shop-ik::admin.fields.password.show') }}"
            title="{{ __('shop-ik::admin.fields.password.show') }}">
            <svg class="icon h-[1em] w-[1em] text-inherit fill-current leading-none shrink-0 block" viewBox="0 0 32 32">
                <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor" fill="none">
                    <path
                        d="M1.409,17.182a1.936,1.936,0,0,1-.008-2.37C3.422,12.162,8.886,6,16,6c7.02,0,12.536,6.158,14.585,8.81a1.937,1.937,0,0,1,0,2.38C28.536,19.842,23.02,26,16,26S3.453,19.828,1.409,17.182Z"
                        stroke-miterlimit="10"></path>
                    <circle cx="16" cy="16" r="6" stroke-miterlimit="10"></circle>
                </g>
            </svg>
        </span>
        <span class="password__btn-label show-password hidden"
            aria-label="{{ __('shop-ik::admin.fields.password.hide') }}"
            title="{{ __('shop-ik::admin.fields.password.hide') }}">
            <svg class="icon h-[1em] w-[1em] text-inherit fill-current leading-none shrink-0 block" viewBox="0 0 32 32">
                <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" stroke="currentColor"
                    fill="none">
                    <path data-cap="butt"
                        d="M8.373,23.627a27.659,27.659,0,0,1-6.958-6.445,1.938,1.938,0,0,1-.008-2.37C3.428,12.162,8.892,6,16.006,6a14.545,14.545,0,0,1,7.626,2.368"
                        stroke-miterlimit="10" stroke-linecap="butt"></path>
                    <path
                        d="M27,10.923a30.256,30.256,0,0,1,3.591,3.887,1.937,1.937,0,0,1,0,2.38C28.542,19.842,23.026,26,16.006,26A12.843,12.843,0,0,1,12,25.341"
                        stroke-miterlimit="10"></path>
                    <path data-cap="butt" d="M11.764,20.243a6,6,0,0,1,8.482-8.489" stroke-miterlimit="10"
                        stroke-linecap="butt"></path>
                    <path d="M21.923,15a6.005,6.005,0,0,1-5.917,7A6.061,6.061,0,0,1,15,21.916" stroke-miterlimit="10">
                    </path>
                    <line x1="2" y1="30" x2="30" y2="2" fill="none"
                        stroke-miterlimit="10"></line>
                </g>
            </svg>
        </span>
    </div>
</div>
