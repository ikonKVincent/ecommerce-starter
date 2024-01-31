<x-dropdown right class="bg-white">
    <x-slot:trigger>
        <div class="appearance-none bg-transparent flex space-x-2 items-center cursor-pointer">
            <div class="w-[40px] h-[40px] rounded-full bg-primary flex justify-center items-center text-white font-bold">
                {{ auth()->guard('admin')->user()->displayNameInitial() }}
            </div>
            <div class="mx-2 lg:mx-3 user-menu__meta">
                <p
                    class="user-menu__meta-title text-sm  leading-none py-0.5 lg:py-1 font-semibold truncate hover:text-quaternary">
                    {{ auth()->guard('admin')->user()->displayName() }}
                </p>
                <p class="text-xs text-contrast-medium leading-none pb-0.5 lg:pb-1">
                    {{ auth()->guard('admin')->user()->Role->name }}
                </p>
            </div>
            <svg class="icon w-[12px] h-[12px]" aria-hidden="true" viewBox="0 0 12 12">
                <polyline points="1 4 6 9 11 4" fill="none" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" />
            </svg>
        </div>
    </x-slot:trigger>
    <x-menu-item title="{{ __('admin.navigation.account') }}" icon="o-user" aria-controls="account-form" />
    <x-menu-item title="{{ __('admin.navigation.website_link') }}" icon="o-globe-alt" />
    <x-menu-item title="{{ __('admin.navigation.update') }}" icon="o-arrow-path" />
    <x-menu-separator />
    <x-menu-item title="{{ __('admin.navigation.logout') }}" icon="o-arrow-left-start-on-rectangle"
        link="{{ route('admin.logout') }}" />
</x-dropdown>
