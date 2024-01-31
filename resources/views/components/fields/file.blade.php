<div>
    @if (!empty($value))
        <input type="hidden" name="medias_positions[{{ $name }}]" value="" class="medias-position">
        <div class="medias-nestable">
            @foreach ($value as $v)
                <div class="form-image flex border border-[#e2e8f0] p-4 mb-5 bg-white text-sm relative gap-5"
                    data-id="{{ $v->id }}">
                    <a class="delete-medias text-error text-base absolute top-1.5 right-1.5"
                        href="{{ route('admin.medias.destroy', ['uuid' => $v->uuid]) }}">
                        <svg class="icon" viewBox="0 0 20 20">
                            <title>{{ __('admin.table.delete') }}</title>
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <line x1="1" y1="5" x2="19" y2="5" />
                                <path d="M7,5V2A1,1,0,0,1,8,1h4a1,1,0,0,1,1,1V5" />
                                <path d="M16,8l-.835,9.181A2,2,0,0,1,13.174,19H6.826a2,2,0,0,1-1.991-1.819L4,8" />
                            </g>
                        </svg>
                    </a>
                    @if (isset($multiple) && $multiple)
                        <div class="handle text-xl cursor-pointer">
                            <x-icon name="o-bars-3" />
                        </div>
                    @endif
                    <div class="image-container">
                        @if (Str::contains($v->mime_type, 'image'))
                            <button class="modal-img-btn rounded-full overflow-hidden border border-accent"
                                aria-controls="modal-image-name" aria-label="Cliquez pour agrandir">
                                <img class="block w-15" src="{{ $v->getUrl('thumb') }}" alt="{{ $v->name }}"
                                    data-src="{{ $v->getUrl() }}">
                                <span class="modal-img-btn__icon-wrapper" aria-hidden="true">
                                    <svg class="icon w-[24px] h-[24px]" viewBox="0 0 24 24">
                                        <g stroke-linecap="square" stroke-linejoin="miter" stroke-width="2"
                                            fill="none" stroke="currentColor" stroke-miterlimit="10">
                                            <path
                                                d="M1.373,13.183a2.064,2.064,0,0,1,0-2.366C2.946,8.59,6.819,4,12,4s9.054,4.59,10.627,6.817a2.064,2.064,0,0,1,0,2.366C21.054,15.41,17.181,20,12,20S2.946,15.41,1.373,13.183Z">
                                            </path>
                                            <circle cx="12" cy="12" r="4"></circle>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        @else
                            <div class="w-15">
                                <x-icon name="o-document-magnifying-glass" class="w-12 h-12" />
                            </div>
                        @endif
                    </div>
                    <div class="image-information">
                        <div class="mime">
                            {{ $v->mime_type }}
                        </div>
                        <div class="size">
                            {{ human_file_size($v->size) }}
                        </div>
                        <div class="download">
                            <a href="{{ $v->getUrl() }}" target="_blank" class="hover:underline">
                                {{ __('admin.download') }}
                            </a>
                        </div>
                    </div>
                    <div class="medias-form w-full">
                        <div class="media-input">
                            <label class="block form-label" for="alt-{{ $v->id }}">Légende</label>
                            <input type="text" name="alt[{{ $v->id }}]" value="{{ $v->name }}"
                                class="form-control w-full" id="alt-{{ $v->id }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    {{-- File --}}
    <div class="file-upload block">
        <input type="file"
            class="file-input file-input-bordered file-input-primary w-full max-w-lg text-sm fileupload"
            name="file-{{ $name }}" name="file-{{ $name }}"
            data-url="{{ route('admin.chunk.upload', ['field' => $name]) }}" data-file-name="{{ $name }}"
            {{ isset($multiple) && $multiple ? 'multiple' : '' }} {!! isset($accept) ? 'accept="' . $accept . '"' : '' !!} />
        @if (isset($helpText))
            <div class="text-component text-xs italic text-accent">{!! $helpText !!}</div>
        @endif
    </div>
    <ul class="list-group file-upload-list">
        <li class="list-group-item my-2 p-2 border hidden">
            <div class="relative bg-gray-200 w-full h-4 mb-2">
                <div class="bg-info absolute top-0 left-0 h-4" style="width:14%"></div>
            </div>
            <div class="flex flex-wrap gap-2 text-sm">
                <span>Nom du fichier : </span>
                <strong>13%</strong>
            </div>
        </li>
    </ul>
    <input type="hidden" name="{{ $name }}" value="">
</div>
