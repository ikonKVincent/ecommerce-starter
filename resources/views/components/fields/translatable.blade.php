<div x-data="{ showTranslations: {{ $expanded ? 'true' : 'false' }} }">
    @if ($showTranslatable)
        <button x-on:click.prevent="showTranslations = !showTranslations"
            class="inline-flex items-center gap-2 px-2 py-1 mb-1 text-gray-700 bg-white border rounded shadow-sm hover:bg-lightGray"
            :class="{ 'bg-gray-100': showTranslations }" type="button">
            <i class="las la-language text-xl"></i>
            <span class="text-xs font-medium">
                {{ __('admin.translate') }}
            </span>
        </button>
    @endif
    <div class="flex items-center gap-2">
        <div x-show="showTranslations" x-cloak>
            <span class="px-2 py-1 text-xs text-gray-600 uppercase bg-lightGray border rounded ">
                {{ $default->code }}
            </span>
        </div>
        <div class="grow">
            {{ $slot }}
        </div>
    </div>
    @if ($showTranslatable)
        <div class="mt-2 space-y-2" x-show="showTranslations" x-cloak>
            @foreach ($languages as $language)
                @if (${"{$language->code}"} ?? null)
                    <div class="relative flex items-center gap-2 mt-2" wire:key="language-{{ $language->id }}">
                        <span class="px-2 py-1 text-xs text-gray-600 uppercase bg-lightGray border rounded ">
                            {{ $language->code }}
                        </span>

                        <div class="w-full">
                            {{ ${"{$language->code}"} ?? null }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
