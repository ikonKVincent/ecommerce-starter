<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    @include('components.seo_metas', ['seo_robot' => false])
    @vite(['resources/scss/admin.scss'])
    @stack('style')
    @livewireStyles
</head>

<body class="min-h-screen antialiased">
    <div class="bg-[#f8f9fb]">
        {{-- Aside --}}
        <aside class="hidden xl:flex pointer-events-none fixed start-0 top-0 z-10 h-full">
            {{-- Main navigation --}}
            <div class="main-navigation">
                <div class="text-xl mt-4 px-4">
                    @include('components.logo')
                </div>
                <nav role="navigation">
                    <x-menu activate-by-route>
                        @include('admin.components.main_navigation')
                    </x-menu>
                </nav>
            </div>
        </aside>
        {{-- Main --}}
        <section class="main" role="main">
            <div class="main-content">
                <div class="px-6 py-4 flex flex-wrap items-center justify-between border-b">
                    <div class=""></div>
                    {{-- Head Navigation --}}
                    <div class="flex space-x-6 items-center">
                        {{-- Notifications --}}
                        <a href="#0"
                            class="flex h-[40px] w-[40px] justify-center items-center bg-white border rounded-md p-1 hover:bg-base-300 duration-200 relative">

                            <x-icon name="o-bell" class="w-6 h-6" />
                            <x-badge value="2"
                                class="badge-secondary indicator-item text-white absolute left-1/2 -translate-x-1/2 -top-3" />
                        </a>
                        {{-- User menu --}}
                        @include('admin.components.user-menu')
                    </div>
                </div>
                {{-- Page content --}}
                <div class="px-6 py-4 ">
                    @if (session()->has('success'))
                        <x-alerts.alert type="success" class="mb-4" />
                    @endif
                    @if (session()->has('error'))
                        <x-alerts.alert type="error" class="mb-4" />
                    @endif
                    @yield('content')
                </div>
            </div>
        </section>
    </div>
    {{-- Account form --}}
    <div class="drawer drawer--modal js-drawer js-drawer--modal" data-drawer-prevent-scroll="body" id="account-form">
        <div class="drawer__content bg-white shadow-lg" role="alertdialog">
            <div class="drawer__body p-5 lg:p-8 js-drawer__body">
                @livewire('admin.administrators.form.account-form')
            </div>
            {{-- Close --}}
            <button class="drawer__close-btn fixed top-0 right-0 z-10 m-2 lg:m-3 js-drawer__close js-tab-focus">
                <svg class="icon inline-block text-inherit fill-current leading-none shrink-0 w-[16px] h-[16px]"
                    viewBox="0 0 16 16">
                    <title>{{ __('admin.close') }}</title>
                    <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round" stroke-miterlimit="10">
                        <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                        <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                    </g>
                </svg>
            </button>
        </div>
    </div>
    {{-- Modal IMG --}}
    <div id="modal-image" class="modal modal--animate-scale bg-black/90 p-5 lg:p-8 js-modal">
        <div class="modal__content w-full h-full flex justify-center items-center pointer-events-none"
            role="alertdialog" aria-labelledby="" aria-describedby="">
            <img class="block rounded shadow-lg max-h-full max-w-full" src="" alt="Image description">
        </div>
        <button class="modal__close-btn modal__close-btn--outer  js-modal__close js-tab-focus">
            <svg class="icon w-[24px] h-[24px]" viewBox="0 0 24 24">
                <title>Fermer</title>
                <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="3" y1="3" x2="21" y2="21" />
                    <line x1="21" y1="3" x2="3" y2="21" />
                </g>
            </svg>
        </button>
    </div>
    @stack('modals')
    {{-- TOAST  --}}
    <x-toast />
    <div class="fixed bg-success -left-16 -top-16"></div>
    <div class="fixed bg-error -left-16 -top-16"></div>
    {{-- Script --}}
    @vite(['resources/js/admin.js'])
    @livewireScripts
    @stack('scripts')
</body>

</html>
