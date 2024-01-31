<?php

namespace App\Livewire\Admin\Settings\Attributes;

use App\Facades\AttributeManifest;
use App\Facades\DB;
use App\Models\Settings\Attribute;
use App\Models\Settings\AttributeGroup;
use App\Traits\Livewire\WithLanguages;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Mary\Traits\Toast;

class AttributeShow extends Component
{
    use WithLanguages, Toast;

    /**
     * Create Group drawer trigger
     * @var bool
     */
    public bool $showCreateGroupDrawer = false;

    /**
     * Edit Group drawer trigger
     * @var bool
     */
    public bool $showEditGroupDrawer = false;

    /**
     * Attribute drawer trigger
     * @var bool
     */
    public bool $showAttributeDrawer = false;

    /**
     * The type property.
     *
     * @var string
     */
    public $type;

    /**
     * The sorted attribute groups.
     */
    public Collection $sortedAttributeGroups;

    /**
     * Whether we should show the panel to create a new group.
     *
     * @var bool
     */
    public $showGroupCreate = false;

    /**
     * The attribute group id to use for creating an attribute.
     *
     * @var int|null
     */
    public $attributeCreateGroupId = null;

    /**
     * The id of the attribute group to edit.
     *
     * @var int|null
     */
    public $editGroupId;

    /**
     * The id of the attribute group to delete.
     *
     * @var int|null
     */
    public $deleteGroupId;

    /**
     * The id of the attribute to edit.
     *
     * @var int|null
     */
    public $editAttributeId = null;

    /**
     * The ID of the attribute we want to delete.
     *
     * @var int|null
     */
    public $deleteAttributeId = null;

    /**
     * {@inheritDoc}
     */
    protected $listeners = [
        'attribute-group-edit.created' => 'refreshGroups',
        'attribute-group-edit.updated' => 'resetGroupEdit',
        'attribute-edit.created' => 'resetAttributeEdit',
        'attribute-edit.updated' => 'resetAttributeEdit',
        'attribute-edit.closed' => 'resetAttributeEdit',
    ];

    /**
     * {@inheritDoc}
     */
    public function mount()
    {
        $this->sortedAttributeGroups = $this->attributeGroups;
    }


    /**
     * Get the current attribute type class.
     *
     * @return string
     */
    public function getTypeClassProperty()
    {
        return AttributeManifest::getType($this->type);
    }

    /**
     * Return the attribute groups for this type class.
     *
     * @return Collection
     */
    public function getAttributeGroupsProperty(): Collection
    {
        return AttributeGroup::whereAttributableType($this->typeClass)
            ->orderBy('position')->get();
    }

    /**
     * Set edit group ID
     * @param string $id
     *
     * @return void
     */
    public function setEditGroupId(string $id): void
    {
        $this->showEditGroupDrawer = true;
        $this->editGroupId = $id;
    }

    /**
     * Set Attribute Group for Create Attribute
     * @param string $groupId
     *
     * @return void
     */
    public function setAttributeCreateGroupId(string $groupId): void
    {
        $this->attributeCreateGroupId = $groupId;
        $this->editAttributeId = null;
        $this->showAttributeDrawer = true;
    }

    /**
     * Return the group to be used when creating an attribute.
     *
     * @return AttributeGroup|null
     */
    public function getAttributeCreateGroupProperty(): AttributeGroup|null
    {
        return AttributeGroup::find($this->attributeCreateGroupId);
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.settings.attributes.attribute-show');
    }

    /**
     * Sort the attribute groups.
     *
     * @param  array  $groups
     * @return void
     */
    public function sortGroups(array $groups): void
    {
        DB::transaction(function () use ($groups) {
            $this->sortedAttributeGroups = $this->attributeGroups->map(function ($group) use ($groups) {
                $updatedOrder = collect($groups['items'])->first(function ($updated) use ($group) {
                    return $updated['id'] == $group->id;
                });
                $group->position = $updatedOrder['order'];
                $group->save();

                return $group;
            })->sortBy('position');
        });
        $this->flushCache();
        // Toast
        $this->toast(
            type: 'success',
            title: 'La position des attributs a bien été enregistrée.'
        );
    }

    /**
     * Sort the attributes.
     *
     * @param  array  $attributes
     * @return void
     */
    public function sortAttributes(array $attributes): void
    {
        DB::transaction(function () use ($attributes) {
            foreach ($attributes['items'] as $attribute) {
                Attribute::whereId($attribute['id'])->update([
                    'position' => $attribute['order'],
                    'attribute_group_id' => $attributes['owner'],
                ]);
            }
        });
        $this->flushCache();
        $this->refreshGroups();

        // Toast
        $this->toast(
            type: 'success',
            title: 'La position des attributs a bien été enregistrée.'
        );
    }

    /**
     * Refresh the attribute groups.
     *
     * @return void
     */
    public function refreshGroups(): void
    {
        $this->sortedAttributeGroups = AttributeGroup::whereAttributableType($this->typeClass)
            ->orderBy('position')->get();

        $this->showGroupCreate = false;
        $this->showCreateGroupDrawer = false;
    }

    /**
     * open Model for crate Group
     * @return void
     */
    public function setGroupCreate(): void
    {
        $this->showGroupCreate = true;
        $this->showCreateGroupDrawer = true;
    }

    /**
     * Return the computed property for the group to edit.
     *
     * @return AttributeGroup|null
     */
    public function getAttributeGroupToEditProperty(): AttributeGroup|null
    {
        if (!$this->editGroupId) {
            return null;
        }
        return AttributeGroup::query()->where('id', $this->editGroupId)->first();
    }

    /**
     * Return the attribute marked for deletion.
     *
     * @return AttributeGroup|null
     */
    public function getAttributeGroupToDeleteProperty(): AttributeGroup|null
    {
        if (!$this->deleteGroupId) {
            return null;
        }
        return AttributeGroup::query()->where('id', $this->deleteGroupId)->first();
    }

    /**
     * @param string $id
     *
     * @return void
     */
    public function setEditAttributeId(string $id): void
    {
        $this->editAttributeId = $id;
        $this->attributeCreateGroupId = null;
        $this->showAttributeDrawer = true;
    }

    /**
     * Return the attribute to edit.
     *
     * @return Attribute|null
     */
    public function getAttributeToEditProperty(): Attribute|null
    {
        if (!$this->editAttributeId) {
            return null;
        }
        return Attribute::query()->where('id', $this->editAttributeId)->first();
    }

    /**
     * Return the attribute to delete.
     *
     * @return  int|null
     */
    public function getAttributeToDeleteProperty(): int|null
    {
        if (!$this->deleteAttributeId) {
            return null;
        }
        return Attribute::query()->where('id', $this->deleteAttributeId)->first();
    }

    /**
     * Returns whether the group to delete has system attributes
     * associated to it and therefore protected.
     *
     * @return bool
     */
    public function getGroupProtectedProperty(): bool
    {
        return $this->attributeGroupToDelete ?
            $this->attributeGroupToDelete->attributes->filter(
                fn ($attribute) => (bool) $attribute->system
            )->count() : false;
    }

    /**
     * Reset the group editing state.
     *
     * @return void
     */
    public function resetGroupEdit(): void
    {
        $this->editGroupId = null;

        $this->showEditGroupDrawer = false;
    }

    /**
     * Reset the attribute edit state.
     *
     * @return void
     */
    public function resetAttributeEdit(): void
    {
        $this->attributeCreateGroupId = null;
        $this->editAttributeId = null;
        $this->refreshGroups();
    }

    public function setDeleteGroupId(string $id): void
    {
        $this->deleteGroupId = $id;
        $this->deleteGroup();
    }

    public function setDeleteAttributeId(string $id): void
    {
        $this->deleteAttributeId = $id;
        $this->deleteAttribute();
    }

    /**
     * Delete the attribute group.
     *
     * @return void
     */
    public function deleteGroup(): void
    {
        // If the group has system attributes, we can't delete it.
        if ($this->groupProtected) {
            $this->toast(
                type: 'error',
                title: __('admin.attribute_groups.delete_error')
            );
            return;
        }
        DB::transaction(function () {
            DB::connection(config('lunar.database.connection'))
                ->table(config('lunar.database.table_prefix') . 'attributables')
                ->whereIn(
                    'attribute_id',
                    $this->attributeGroupToDelete->attributes()->pluck('id')->toArray()
                )->delete();
            $this->attributeGroupToDelete->attributes()->delete();
            $this->attributeGroupToDelete->delete();
        });
        $this->deleteGroupId = null;
        $this->flushCache();
        $this->refreshGroups();

        $this->toast(
            type: 'success',
            title: __('admin.attribute_groups.delete_success')
        );
    }

    /**
     * Delete an attribute
     *
     * @return void
     */
    public function deleteAttribute(): void
    {
        DB::transaction(function () {
            DB::connection(config('lunar.database.connection'))
                ->table(config('lunar.database.table_prefix') . 'attributables')
                ->where(
                    'attribute_id',
                    $this->attributeToDelete->id
                )->delete();

            $this->attributeToDelete->delete();
        });

        $this->toast(
            type: 'success',
            title: __('admin.attributes.delete_success')
        );
        $this->deleteAttributeId = null;
        $this->flushCache();
        $this->refreshGroups();
    }

    /**
     * Flush attributes & group query cache
     *
     * @return void
     */
    private function flushCache(): void
    {
        AttributeGroup::flushQueryCache();
        Attribute::flushQueryCache();
    }
}
