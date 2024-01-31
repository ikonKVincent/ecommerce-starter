{{-- Dashboard --}}
<x-menu-item title="{{ __('admin.navigation.dashboard') }}" icon="o-home" link="{{ route('admin.dashboard') }}" />
{{-- Settings --}}
<x-menu-separator title="{{ __('admin.navigation.settings') }}" icon="o-cog-6-tooth" />
{{-- Admins --}}
@canany(['read', 'create', 'edit', 'delete'], new \App\Models\Admins\Admin())
    <x-menu-sub title="{{ __('admin.navigation.administrators') }}" icon="o-user">
        <x-menu-item title="{{ __('admin.navigation.administrator_users') }}" icon="o-user-plus"
            link="{{ route('admin.admins.users.index') }}" />
        <x-menu-item title="{{ __('admin.navigation.administrator_roles') }}" icon="o-shield-exclamation"
            link="{{ route('admin.admins.roles.index') }}" />
    </x-menu-sub>
@endcan
{{-- Settings --}}
<x-menu-sub title="{{ __('admin.navigation.settings') }}" icon="o-cog-8-tooth">
    <x-menu-item title="{{ __('admin.navigation.setting_languages') }}" icon="o-flag" />
    <x-menu-item title="{{ __('admin.navigation.setting_attributes') }}" icon="o-ticket"
        link="{{ route('admin.settings.attributes.index') }}" />
    <x-menu-item title="{{ __('admin.navigation.setting_website') }}" icon="o-globe-alt" />
    <x-menu-item title="{{ __('admin.navigation.setting_logs') }}" icon="o-exclamation-triangle" />
</x-menu-sub>
