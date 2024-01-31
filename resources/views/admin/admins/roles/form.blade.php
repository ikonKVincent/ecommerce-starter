@extends('layouts.admin.app')

@section('content')
    {{-- Form --}}
    <form method="post" action="{{ $role->id ? route($route . 'update', ['id' => $role->id]) : route($route . 'store') }}"
        enctype="multipart/form-data">
        @csrf
        @if ($role->id)
            <input type="hidden" name="_method" value="put" />
        @endif

        {{-- Page title --}}
        <div class="sticky top-5 left-0 w-full form-buttons">
            <x-header title="{!! !$role->id ? __('admin.admins.roles.create') : __('admin.admins.roles.edit', ['name' => $role->name]) !!}" subtitle="{{ __('admin.admins.roles.description') }}"
                size="text-3xl font-light">
                <x-slot:actions>
                    @include('admin.components.form_buttons')
                </x-slot:actions>
            </x-header>
        </div>

        {{-- Errors --}}
        @if ($errors->all())
            <x-alerts.validation-alert class="mb-4" />
        @endif
        <x-tabs selected="informations-tab">
            {{-- Informations --}}
            <x-tab name="informations-tab" label="Informations" icon="o-information-circle">
                {{-- Name --}}
                <x-fields.group label="{{ __('admin.admins.roles.name') }}" for="name"
                    instructions="{{ __('admin.form.required') }}" required :error="$errors->first('name')">
                    <x-fields.text id="name" name="name" value="{{ old('name') ?? $role->name }}"
                        :error="$errors->first('name')" />
                </x-fields.group>
            </x-tab>
            {{-- Admins --}}
            @if ($role->id)
                <x-tab name="admins-tab" label="Administrateurs" icon="o-user">
                    @livewire('admin.administrators.table.admins-table', [
                        'role_id' => $role->id,
                    ])
                </x-tab>
            @endif
            {{-- Permissions --}}
            @if ($role->name != 'SuperAdmin' && !empty($permissions))
                <x-tab name="permissions-tab" label="Permissions" icon="o-lock-closed">
                    @foreach ($permissions as $section => $modules)
                        <div class="border rounded-xl p-4 mb-4">
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-6 border-b mb-4 pb-2">
                                <div class="text-primary font-bold text-xl">{{ $section }}:</div>
                                <a href="#" class="btn  text-sm all-checkboxes">
                                    Tout
                                    selectionner
                                </a>
                            </div>
                            @foreach ($modules as $module => $actions)
                                <div class="grid grid-cols-12 gap-6 mb-4 border-b pb-4 ">
                                    <div class="col-span-12 md:col-span-4 font-bold text-sm">
                                        {{ $module }} :
                                    </div>
                                    <div class="col-span-12 md:col-span-8 text-xs">
                                        <div class="flex flex-wrap gap-4 items-center">
                                            @foreach ($actions as $action => $value)
                                                <div class="">
                                                    <input class="checkbox" type="checkbox" value="1"
                                                        name="permissions[{{ $section }}][{{ $module }}][{{ $action }}]"
                                                        id="{{ $section }}-{{ $module }}-{{ $action }}"
                                                        {{ $value ? 'checked' : '' }}>
                                                    <label
                                                        for="{{ $section }}-{{ $module }}-{{ $action }}">
                                                        {{ __('admin.admins.permissions.' . $action) }}
                                                    </label>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </x-tab>
            @endif
        </x-tabs>

    </form>
@endsection
