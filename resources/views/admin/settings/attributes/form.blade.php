@extends('layouts.admin.app')

@section('content')
    {{-- Page title --}}
    <div class="sticky top-5 left-0 w-full form-buttons">
        <x-header title="{{ $title }}" subtitle="{{ __('admin.settings.attributes.description') }}"
            size="text-3xl font-light">
            <x-slot:actions>
                <x-button icon="o-arrow-left" class="btn-primary" label="{{ __('admin.form.cancel_return') }}"
                    link="{{ route($route . 'index') }}" responsive spinner />
            </x-slot:actions>
        </x-header>
    </div>
    @livewire('admin.settings.attributes.attribute-show', [
        'type' => $type,
    ])
@endsection
