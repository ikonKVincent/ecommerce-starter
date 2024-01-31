@extends('layouts.admin.auth')

@section('content')
    <div class="mx-auto max-w-xl relative">
        <div
            class="absolute inset-0 bg-gradient-to-r from-primary-darker to-primary-lighter shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl hidden md:block form-gradient">
        </div>
        <div class="relative p-4 md:p-8 rounded-xl border shadow-lg bg-white">
            {{-- Login Text --}}
            <div class="text-component text-center mb-6">
                <div class="text-primary text-2xl">
                    @include('components.logo')
                </div>
                <p class="text-sm">
                    {{ __('admin.auth.forgot_password') }}
                </p>
            </div>
            {{-- Password Form --}}
            @livewire('admin.auth.password-forget-form')
            {{-- Return --}}
            <div class="flex justify-center mt-8">
                <a href="{{ route('admin.login') }}" class="text-sm text-blue hover:underline">
                    {{ __('admin.auth.return') }}
                </a>
            </div>
        </div>
    </div>
@endsection
