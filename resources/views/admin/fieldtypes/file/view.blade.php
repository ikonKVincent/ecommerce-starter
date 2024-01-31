<div>
    @php

        $field_value = [];
        if (old($field['signature'])) {
            $field_value[] = $field['signature'];
        }
        if (isset($field['data']) && $field['data']) {
            $field_value[] = $field['data'];
        }
        $is_multiple = false;
        if (isset($field['configuration']['max_files'])) {
            if ($field['configuration']['max_files'] > 1) {
                $is_multiple = true;
            }
        }
    @endphp
    @if (!empty($field_value))
        @foreach ($field_value as $v)
            <div class="form-image flex border border-[#e2e8f0] p-4 mb-5 bg-white text-sm relative gap-5"
                data-id="{{ $v['id'] }}">
                <a class="delete-medias text-error text-base absolute top-1.5 right-1.5"
                    href="{{ route('admin.medias.destroy', ['uuid' => $v['uuid']]) }}">
                    <svg class="icon" viewBox="0 0 20 20">
                        <title>{{ __('admin.medias.delete') }}</title>
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2">
                            <line x1="1" y1="5" x2="19" y2="5" />
                            <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5" />
                            <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8" />
                        </g>
                    </svg>
                </a>
                <div class="image-container">

                    <div class="w-10">
                        <i class="las la-file-alt text-6xl"></i>
                    </div>
                </div>
                <div class="image-information">
                    <div class="mime">
                        {{ $v['mime_type'] }}
                    </div>
                    <div class="size">
                        {{ human_file_size($v['size']) }}
                    </div>
                    <div class="download">
                        <a href="{{ $v['original_url'] }}" target="_blank">
                            {{ __('admin.download') }}
                        </a>
                    </div>
                </div>
                <div class="medias-form w-full">
                    <div class="media-input">
                        <label class="block form-label" for="alt-{{ $v['id'] }}">{{ __('admin.legend') }}</label>
                        <input type="text" name="alt[{{ $v['id'] }}]" value="{{ $v['name'] }}"
                            class="form-control w-full" id="alt-{{ $v['id'] }}">
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="file-upload inline-block">
        <label for="attributes[{{ $field['signature'] }}]" class="file-upload__label">
            <label for="attributes[{{ $field['signature'] }}]" class="file-upload__label btn btn--primary">
                <span class="flex items-center">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M2 16v6h20v-6"></path>
                            <path stroke-linejoin="miter" stroke-linecap="butt" d="M12 17V2"></path>
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M18 8l-6-6-6 6"></path>
                        </g>
                    </svg>
                    <span class="ml-1.5 lg:ml-2 file-upload__text file-upload__text--has-max-width">
                        {{ isset($upload_name) ? $uplaod_name : ($is_multiple ? __('admin.upload') : __('admin.upload_single')) }}
                    </span>
                </span>
            </label>
        </label>
        <input type="file" class="file-upload__input"
            name="attributes[{{ $field['signature'] }}]{{ $is_multiple ? '[]' : '' }}"
            id="attributes[{{ $field['signature'] }}]" {{ $is_multiple ? 'multiple' : '' }}>
        <input type="hidden" name="attributes[{{ $field['signature'] }}]{{ $is_multiple ? '[]' : '' }}"
            class="file-attribute" value="{{ !empty($field_value) ? json_encode($field_value) : null }}">
    </div>

    @error('attributes[' . $field['signature'] . ']')
        <p class="text-error text-sm italic mt-2 leading-none">{{ $message }}</p>
    @enderror

</div>
