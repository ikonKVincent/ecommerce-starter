@extends('layouts.admin.app')

@section('content')
    {{-- Page title --}}
    <x-header title="{{ __('admin.navigation.dashboard') }}" size="text-3xl font-light" />

    <div class="grid grid-cols-12 gap-6 mb-6">
        {{-- Welcome --}}
        <div class="hidden lg:block lg:col-span-3 ratio_109 ">
            <div
                class="card p-4 before:!pt-0 bg-primary relative common-animate-main 4xl:h-[390px] xl:h-full gap-0 rounded-xl h-[410px] bg-size">
                <div>
                    <div class="flex items-center gap-2 justify-between"> <span
                            class="flex items-center gap-2 text-3xl font-semibold text-white 3sm:text-lg 5xl:text-2xl">
                            {{ __('admin.common.welcome') }} {{ auth()->guard('admin')->user()->displayName() }}
                            <img class="w-[22px] h-[22px]" src="/images/admin/waving-hand.png" alt="waving-hand"></span>
                    </div>
                    <p class="text-sm font-semibold text-white leading-[22px] mt-1 sm:line-clamp-none">
                        {{ __('admin.common.welcome_text') }}
                    </p>
                </div>
                <div class="relative bg-img mt-2">
                    <img class="img-fluid welcome-img" src="/images/admin/dashboard.svg" alt="welcome-image">
                    <img class="w-[28px] h-[28px] common-animate animate-ping top-[14px] 6xl:top-[30px] 4xl:top-[14px] absolute left-[10%] 2md:left-[24%] sm:left-[10%] animate__animated animate__infinite animate__shakeY animate__slower"
                        src="./images/admin/done.svg" alt="welcome-done-image">
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-9">
            <div class="bg-warning"></div>
            <div class="rounded-xl border p-4">
                {{-- Alerts --}}
                @if (isset($alert_message) && !empty($alert_message))
                    <x-alert icon="o-exclamation-triangle" class="alert-warning">
                        <div>
                            <p class="note__title  text-contrast-higher">
                                <strong> Information{{ $total_alert > 1 ? 's' : '' }}
                                    importante{{ $total_alert > 1 ? 's' : '' }}
                                    !</strong>
                            </p>
                            @foreach ($alert_message as $a_k => $a_message)
                                <p class="text-sm {{ $a_k + 1 == $total_alert ? 'margin-bottom-0' : 'margin-bottom-xxs' }}">
                                    {!! $a_message !!}
                                </p>
                            @endforeach
                        </div>
                    </x-alert>
                @endif
            </div>
        </div>

    </div>
@endsection
