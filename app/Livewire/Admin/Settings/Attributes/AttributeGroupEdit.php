<?php

namespace App\Livewire\Admin\Settings\Attributes;

use App\Models\Settings\AttributeGroup;
use App\Traits\Livewire\WithLanguages;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Mary\Traits\Toast;

class AttributeGroupEdit extends Component
{
    use WithLanguages, Toast;

    /**
     * The type of attributable this is.
     *
     * @var string
     */
    public $attributableType;

    /**
     * The handle for the attributable type.
     *
     * @var string
     */
    public $typeHandle;

    /**
     * The new attribute group.
     *
     * @var AttributeGroup
     */
    public ?AttributeGroup $attributeGroup = null;

    /**
     * Attribute name
     * @var array
     */
    public array $attribute_name = [];

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        $rules = [];

        $this->languages->each(function ($language) use (&$rules) {
            $rules["attribute_name.{$language->code}"] = array_merge(
                ['string', 'max:255'],
                $language->default ? ['required'] : []
            );
        });

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function mount()
    {
        $this->attributeGroup = $this->attributeGroup ?: new AttributeGroup();
        foreach ($this->languages as $lang) {
            $this->attribute_name[$lang->code] = $this->attributeGroup->translate('name', $lang->code);
        }
    }

    /**
     * Create / Update attribute group
     * @return void
     */
    public function create(): void
    {
        $this->validate();

        $handle = Str::handle("{$this->typeHandle}_{$this->attribute_name[$this->defaultLanguage->code]}");
        $this->attributeGroup->handle = $handle;

        $uniquenessConstraint = 'unique:' . get_class($this->attributeGroup) . ',handle';
        if ($this->attributeGroup->id) {
            $uniquenessConstraint .= ',' . $this->attributeGroup->id;
        }

        $this->validate([
            'attributeGroup.handle' => $uniquenessConstraint,
        ]);

        if ($this->attributeGroup->id) {
            $this->attributeGroup->name = $this->attribute_name;
            $this->attributeGroup->save();
            $this->dispatch('attribute-group-edit.updated', $this->attributeGroup->id);
            $this->dispatch('close-drawer', drawer: 'attribute-create-form');
            // Toast
            $this->toast(
                type: 'success',
                title: __('admin.attribute_groups.update_success')
            );

            return;
        }

        $this->attributeGroup->name = $this->attribute_name;
        $this->attributeGroup->attributable_type = $this->attributableType;
        $this->attributeGroup->position = AttributeGroup::whereAttributableType(
            $this->attributableType
        )->count() + 1;

        $this->attributeGroup->handle = $handle;
        $this->attributeGroup->save();

        $this->dispatch('attribute-group-edit.created', $this->attributeGroup->id);
        $this->dispatch('close-drawer', drawer: 'attribute-create-form');
        $this->attributeGroup = new AttributeGroup();
        // Toast
        $this->toast(
            type: 'success',
            title: __('admin.attribute_groups.create_success')
        );
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.settings.attributes.attribute-group-edit');
    }
}
