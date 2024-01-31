<div>
    <div class="flex justify-end mb-6">
        <x-button icon="o-plus" class="btn-info" label="{!! __('admin.attribute_groups.create') !!}" spinner
            wire:click.prevent="setGroupCreate" />
    </div>
    <div wire:sort sort.options='{group: "groups", method: "sortGroups"}' class="space-y-2">
        @forelse($sortedAttributeGroups as $group)
            <div wire:key="group_{{ $group->id }}" x-data="{ expanded: {{ $group->attributes->count() <= 4 ? 'true' : 'false' }} }" sort.item="groups"
                sort.id="'{{ $group->id }}'">
                {{-- Group --}}
                <div class="flex items-center gap-2 ">
                    <div wire:loading wire:target="sort">
                        Loading
                    </div>
                    <div wire:loading.remove wire:target="sort">
                        <div sort.handle class="cursor-grab">
                            <x-icon name="o-chevron-up-down" class="w-6 h-6 mr-2 text-gray-400 hover:text-gray-700" />
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between w-full p-3 text-sm bg-white border border-transparent rounded shadow-sm sort-item-element hover:border-gray-300">
                        <div class="flex items-center justify-between expand">
                            {{ $group->name }}
                        </div>
                        <div class="flex space-x-2">
                            @if ($group->attributes->count())
                                <button @click="expanded = !expanded">
                                    <div class="transition-transform"
                                        :class="{
                                            '-rotate-90 ': expanded
                                        }">
                                        <x-icon name="o-chevron-left" class="w-6 h-6" />
                                    </div>
                                </button>
                            @endif
                            <x-dropdown icon="o-ellipsis-vertical" class="btn-sm" spinner>
                                <x-menu-item title="Modifier le groupe d'attribut" icon="o-pencil"
                                    wire:click="setEditGroupId('{{ $group->id }}')" />
                                <x-menu-item title="Créer un nouvel attribut" icon="o-plus"
                                    wire:click="setAttributeCreateGroupId('{{ $group->id }}')" />
                                <x-menu-item title="Supprimer ce groupe d'attribut" icon="o-trash" class="text-error"
                                    wire:click="setDeleteGroupId( '{{ $group->id }}')" />
                            </x-dropdown>
                        </div>
                    </div>
                </div>
                {{-- Attributes --}}
                <div class="py-4 pl-2 pr-4 mt-2 space-y-2 bg-black border-l rounded bg-opacity-5 ml-7"
                    @if ($group->attributes->count()) x-cloak
                        x-show="expanded" @endif>
                    <div class="space-y-2" wire:sort
                        sort.options='{group: "attributes", method: "sortAttributes", owner: '{{ $group->id }}'}'
                        x-show="expanded">
                        @foreach ($group->attributes as $attribute)
                            <div class="flex items-center justify-between w-full p-3 text-sm bg-white border border-transparent rounded shadow-sm sort-item-element hover:border-gray-300"
                                wire:key="attribute_{{ $attribute->id }}" sort.item="attributes"
                                sort.parent="{{ $group->id }}" sort.id="{{ $attribute->id }}">
                                <div sort.handle class="cursor-grab">
                                    <x-icon name="o-chevron-up-down"
                                        class="w-6 h-6 mr-2 text-gray-400 hover:text-gray-700" />
                                </div>
                                <span class="truncate grow">{{ $attribute->name }}</span>
                                <div class="mr-4 text-xs text-gray-500">
                                    {{ class_basename($attribute->type) }}
                                </div>
                                <div>
                                    <x-dropdown icon="o-ellipsis-vertical" class="btn-sm">
                                        <x-menu-item title="Modifier" icon="o-pencil"
                                            wire:click="setEditAttributeId('{{ $attribute->id }}')" />
                                        <x-menu-item title="Supprimer" icon="o-trash" class="text-error"
                                            wire:click="setDeleteAttributeId('{{ $attribute->id }}')" />
                                    </x-dropdown>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if (!$group->attributes->count())
                        <span class="mx-4 text-sm text-gray-500">
                            Aucun attribut n'a été créé. Vous pouvez en crééer un.
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="w-full text-center text-gray-500">
                {{ __('admin.attribute_groups.empty') }}
            </div>
        @endforelse
    </div>
    {{-- Drawer Group Create --}}
    <x-drawer id="group-create-form" title="{!! __('admin.attribute_groups.create') !!} " with-close-button separator right
        class="lg:w-[600px]" wire:model="showCreateGroupDrawer">
        @livewire(
            'admin.settings.attributes.attribute-group-edit',
            [
                'typeHandle' => $type,
                'attributableType' => $this->typeClass,
            ],
            key("'create-" . now() . "'")
        )
    </x-drawer>
    {{-- Drawer Group Edit --}}
    <x-drawer id="group-edit-form" title="{!! __('admin.attribute_groups.edit') !!} : {{ $this->attributeGroupToEdit?->name }}"
        with-close-button separator right class="lg:w-[600px]" wire:model="showEditGroupDrawer">
        @livewire(
            'admin.settings.attributes.attribute-group-edit',
            [
                'typeHandle' => $type,
                'attributableType' => $this->typeClass,
                'attributeGroup' => $this->attributeGroupToEdit,
            ],
            key("'edit-" . now() . "'")
        )
    </x-drawer>
    {{-- Attribute Drawer --}}
    <x-drawer id="attribute-create-form" title="{!! $this->attributeToEdit ? __('admin.attributes.update') : __('admin.attributes.create') !!}" with-close-button separator right
        class="lg:w-[600px]" wire:model="showAttributeDrawer">
        @if ($this->attributeCreateGroup)
            @livewire(
                'admin.settings.attributes.attribute-edit',
                [
                    'group' => $this->attributeCreateGroup,
                ],
                key("'a-create-" . now() . "'")
            )
        @endif
        @if ($this->attributeToEdit)
            <div class="">
                @livewire(
                    'admin.settings.attributes.attribute-edit',
                    [
                        'attribute' => $this->attributeToEdit,
                    ],
                    key("'a-edit-" . now() . "'")
                )
            </div>
        @endif
    </x-drawer>

</div>
