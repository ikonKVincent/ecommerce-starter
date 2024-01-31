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

<body>
    {{-- Main --}}
    <div class="relative" role="main">
        <figure class="absolute top-0 left-0 pointer-events-none w-full h-full overflow-hidden z-[1]"
            aria-hidden="true">
            <svg class="absolute top-0 left-2/4 -translate-x-2/4 w-[134%] min-w-[1280px] max-w-[1920px] h-auto"
                viewBox="0 0 1920 450" fill="none">
                <rect opacity="0.5" x="610.131" y="-440" width="128" height="836.003"
                    transform="rotate(46.8712 610.131 -440)" fill="url(#bg-decoration-v1-fx-5-linear-1)" />
                <rect opacity="0.5" x="1899.13" y="-262" width="128" height="836.003"
                    transform="rotate(46.8712 1899.13 -262)" fill="url(#bg-decoration-v1-fx-5-linear-2)" />
                <rect opacity="0.5" x="2076.13" y="-321" width="128" height="836.003"
                    transform="rotate(46.8712 2076.13 -321)" fill="url(#bg-decoration-v1-fx-5-linear-3)" />
                <rect opacity="0.5" x="1294.5" y="40.3308" width="128" height="836.003"
                    transform="rotate(-132.518 1294.5 40.3308)" fill="url(#bg-decoration-v1-fx-5-linear-4)" />
                <rect opacity="0.5" x="1866.13" y="-453" width="128" height="836.003"
                    transform="rotate(46.8712 1866.13 -453)" fill="url(#bg-decoration-v1-fx-5-linear-5)" />
                <rect opacity="0.5" x="800.131" y="-418" width="128" height="836.003"
                    transform="rotate(46.8712 800.131 -418)" fill="url(#bg-decoration-v1-fx-5-linear-5)" />
                <rect opacity="0.5" x="436.448" y="-251" width="76.1734" height="340.424"
                    transform="rotate(46.8712 436.448 -251)" fill="url(#bg-decoration-v1-fx-5-linear-7)" />
                <defs>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-1" x1="674.131" y1="-440" x2="674.131"
                        y2="396.003" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-2" x1="1963.13" y1="-262" x2="1963.13"
                        y2="574.003" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-3" x1="2140.13" y1="-321" x2="2140.13"
                        y2="515.003" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-4" x1="1358.5" y1="40.3308" x2="1358.5"
                        y2="876.334" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-5" x1="1930.13" y1="-453" x2="1930.13"
                        y2="383.003" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-5" x1="864.131" y1="-418" x2="864.131"
                        y2="418.003" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                    </linearGradient>
                    <linearGradient id="bg-decoration-v1-fx-5-linear-7" x1="474.534" y1="-251" x2="474.534"
                        y2="89.4236" gradientUnits="userSpaceOnUse">
                        <stop stop-color="hsl(221 39% 11% / 0.4)" stop-opacity="0" />
                        <stop offset="1" stop-color="hsl(221 39% 11% / 0.4)" />
                    </linearGradient>
                </defs>
            </svg>
        </figure>
        <section class="flex min-h-screen justify-center items-center bg-contain bg-bottom bg-no-repeat">
            <div class="l-container">
                @yield('content')
            </div>
        </section>
    </div>
    {{-- Script --}}
    @livewireScripts
    @vite(['resources/js/admin.js'])
    @stack('scripts')
</body>

</html>
