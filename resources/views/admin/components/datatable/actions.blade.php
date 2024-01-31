<x-dropdown>
    <x-slot:trigger>
        <x-icon name="o-ellipsis-vertical" />
    </x-slot:trigger>
    <x-menu-item title="{{ __('admin.table.edit') }}" icon="o-pencil"
        link="{{ route($route . '.edit', ['id' => $id]) }}" />
    <x-menu-item title="{{ __('admin.table.delete') }}" icon="o-trash" class="delete-link text-error"
        data-title="{{ __('admin.table.delete_title') }}" data-description="{{ __('admin.table.delete_description') }}"
        link="{{ route($route . '.destroy', ['id' => $id]) }}" no-wire-navigate />
</x-dropdown>
