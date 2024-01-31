@extends('layouts.admin.app')

@section('content')
    {{-- Page title --}}
    <x-header title="{{ __('admin.admins.users.title') }}" subtitle="{{ __('admin.admins.users.description') }}"
        size="text-3xl font-light">
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" label="Ajouter un administrateur" link="{{ route($route . 'create') }}"
                responsive />
        </x-slot:actions>
    </x-header>
    {{-- Table --}}
    <livewire:admin.administrators.table.admins-table />
@endsection
