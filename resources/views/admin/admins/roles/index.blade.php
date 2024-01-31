@extends('layouts.admin.app')

@section('content')
    {{-- Page title --}}
    <x-header title="{{ __('admin.admins.roles.title') }}" subtitle="{{ __('admin.admins.roles.description') }}"
        size="text-3xl font-light">
        <x-slot:actions>
            <x-button icon="o-plus" class="btn-primary" label="Ajouter un rôle" link="{{ route($route . 'create') }}"
                responsive />
        </x-slot:actions>
    </x-header>
    {{-- Table --}}
    <livewire:admin.administrators.table.admin-roles-table />
@endsection
