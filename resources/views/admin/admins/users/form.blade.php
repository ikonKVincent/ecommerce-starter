@extends('layouts.admin.app')

@section('content')
    {{-- Form --}}
    <form method="post" action="{{ $admin->id ? route($route . 'update', ['id' => $admin->id]) : route($route . 'store') }}"
        enctype="multipart/form-data">
        @csrf
        @if ($admin->id)
            <input type="hidden" name="_method" value="put" />
        @endif

        {{-- Page title --}}
        <div class="sticky top-5 left-0 w-full form-buttons">
            <x-header title="{!! !$admin->id
                ? __('admin.admins.users.create')
                : __('admin.admins.users.edit', ['name' => $admin->displayName()]) !!}" subtitle="{{ __('admin.admins.users.description') }}"
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

        {{-- Enabled --}}
        <x-fields.group label="{{ __('admin.admins.users.enabled') }}" for="enabled" :error="$errors->first('enabled')">
            <x-fields.boolean id="enabled" name="enabled" checked="{{ $admin->enabled ? true : false }}" value="1"
                :error="$errors->first('enabled')" />
        </x-fields.group>

        {{-- Role --}}
        <x-fields.group label="{!! __('admin.admins.users.role') !!}" for="role_id" :error="$errors->first('role_id')" required>
            <div class="flex flex-col md:flex-row gap-5">
                <div class="grow">
                    <x-fields.select id="role_id" name="role_id" :error="$errors->first('role_id')">
                        @foreach ($adminRoles as $role_id => $role_name)
                            <option value="{{ $role_id }}" {{ $admin->role_id == $role_id ? 'selected' : '' }}>
                                {{ $role_name }}
                            </option>
                        @endforeach
                    </x-fields.select>
                </div>
                {{-- Create role --}}
                <x-button label="{{ __('admin.admins.roles.create') }}" icon="o-plus" class="btn-primary" responsive
                    aria-controls="drawer-role-form" />
            </div>
        </x-fields.group>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">

            {{-- Firstname --}}
            <x-fields.group label="{{ __('admin.admins.users.firstname') }}" for="firstname"
                hint="{{ __('admin.form.required') }}" required :error="$errors->first('firstname')">
                <x-fields.text id="firstname" name="firstname" value="{{ old('firstname') ?? $admin->firstname }}"
                    :error="$errors->first('firstname')" />
            </x-fields.group>

            {{-- Lastname --}}
            <x-fields.group label="{{ __('admin.admins.users.lastname') }}" for="lastname"
                hint="{{ __('admin.form.required') }}" required :error="$errors->first('lastname')">
                <x-fields.text id="lastname" name="lastname" value="{{ old('lastname') ?? $admin->lastname }}"
                    :error="$errors->first('lastname')" />
            </x-fields.group>

        </div>

        {{-- Email --}}
        <x-fields.group label="{{ __('admin.admins.users.email') }}" for="email" hint="{{ __('admin.form.required') }}"
            required :error="$errors->first('email')">
            <x-fields.text id="email" type="email" name="email" value="{{ old('email') ?? $admin->email }}"
                :error="$errors->first('email')" />
        </x-fields.group>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
            @php
                $hint = (!$admin->id ? __('admin.form.required') : __('admin.admins.users.password_not_required')) . '<br>' . __('admin.admins.users.password_instruction');
            @endphp
            {{-- Password --}}
            <x-fields.group label="{{ __('admin.admins.users.password') }}" for="password" hint="{!! $hint !!}"
                required :error="$errors->first('password')">
                <x-fields.password id="password" name="password" value="{{ old('password') }}" :error="$errors->first('password')" />
            </x-fields.group>

            {{-- Password Confirmation --}}
            <x-fields.group label="{{ __('admin.admins.users.password_confirmation') }}" for="password_confirmation"
                required :error="$errors->first('admin.password_confirmation')">
                <x-fields.password id="password_confirmation" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" :error="$errors->first('password_confirmation')" />
            </x-fields.group>
        </div>

        {{-- Avatar --}}
        <div class="form-group hidden">
            <label for="avatar" class="pt-0 label label-text font-semibold">
                <span>
                    {{ __('admin.admins.users.avatar') }}
                </span>
            </label>
            <input type="file" class="file-input file-input-bordered file-input-primary w-full max-w-lg text-sm"
                name="avatar" accept="image/png, image/gif, image/jpeg" />
            <div class="label-text-alt text-gray-400 p-1 pb-0">
                {{ __('admin.medias.image_instructions') }}
            </div>
        </div>
        {{-- Avatar --}}
        <x-fields.group label="{{ __('admin.admins.users.avatar') }}" for="avatar"
            hint="{{ __('admin.medias.image_instructions') }}" :error="$errors->first('avatar_file')">
            @include('components.fields.file', [
                'name' => 'avatar_file',
                'value' => $admin->getMedia('avatar'),
                'multiple' => false,
                'accept' => 'image/png, image/gif, image/jpeg',
            ])
        </x-fields.group>
    </form>
    {{-- Role form --}}
    <div class="drawer drawer--modal js-drawer js-drawer--modal" data-drawer-prevent-scroll="body" id="drawer-role-form">
        <div class="drawer__content bg-white shadow-lg" role="alertdialog">
            <div class="drawer__body p-5 lg:p-8 js-drawer__body">
                @livewire('admin.administrators.form.role-form', [
                    'route' => $admin->id ? route($route . 'edit', ['id' => $admin->id]) : route($route . 'store'),
                ])
            </div>
            {{-- Close --}}
            <button class="drawer__close-btn fixed top-0 right-0 z-10 m-2 lg:m-3 js-drawer__close js-tab-focus">
                <svg class="icon inline-block text-inherit fill-current leading-none shrink-0 w-[16px] h-[16px]"
                    viewBox="0 0 16 16">
                    <title>{{ __('admin.close') }}</title>
                    <g stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-miterlimit="10">
                        <line x1="13.5" y1="2.5" x2="2.5" y2="13.5"></line>
                        <line x1="2.5" y1="2.5" x2="13.5" y2="13.5"></line>
                    </g>
                </svg>
            </button>
        </div>
    </div>
@endsection
