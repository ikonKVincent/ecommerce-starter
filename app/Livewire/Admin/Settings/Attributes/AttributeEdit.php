<?php

namespace App\Livewire\Admin\Settings\Attributes;

use App\Facades\FieldTypeManifest;
use App\Models\Settings\Attribute;
use App\Models\Settings\AttributeGroup;
use App\Traits\Livewire\WithLanguages;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AttributeEdit extends Component
{
    use WithLanguages, Toast;

    /**
     * The attribute group.
     *
     * @var \App\Models\Settings\AttributeGroup
     */
    public ?AttributeGroup $group = null;

    /**
     * The attribute instance.
     *
     * @var \App\Models\Settings\Attribute
     */
    public ?Attribute $attribute = null;

    /**
     * Whether the panel should be visible.
     */
    public bool $panelVisible = true;

    /**
     * Whether the user has input a handle manually.
     */
    public bool $manualHandle = false;

    public ?string $attribute_type = null;
    public bool $searcheable = true;
    public bool $filterable = false;
    public bool $required = false;
    public string $section = 'main';
    public bool $system = false;
    public array $attribute_name = [];
    public ?string $handle = null;
    public ?string $validation_rules = null;

    /**
     * {@inheritDoc}
     */
    public function mount()
    {
        $this->attribute = $this->attribute ?: new Attribute();

        if ($this->attribute->id) {
            $this->group = $this->attribute->attributeGroup;
            $this->attribute_type = $this->attribute->type;
            $this->searcheable = $this->attribute->searcheable ?? false;
            $this->filterable = $this->attribute->filterable ?? false;
            $this->required = $this->attribute->required ?? false;
            $this->section = $this->attribute->section;
            $this->system = $this->attribute->system ?? false;
            $this->handle = $this->attribute->handle;
            $this->validation_rules = $this->attribute->validation_rules;
        } else {
            $this->attribute_type = get_class($this->fieldTypes->first());
        }
        foreach ($this->languages as $lang) {
            $this->attribute_name[$lang->code] = $this->attribute->translate('name', $lang->code);
        }
    }

    public function updatedPanelVisible($val): void
    {
        $this->dispatch('attribute-edit.closed');
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $rules = [
            'attribute_name' => 'required',
            'handle' => 'required',
            'required' => 'nullable|boolean',
            'searchable' => 'nullable|boolean',
            'filterable' => 'nullable|boolean',
            'configuration' => 'nullable|string',
            'section' => 'nullable|string',
            'system' => 'boolean',
            'attribute_type' => 'required',
            'validation_rules' => 'nullable|string',
        ];

        if (!$this->attribute->id) {
            $rules['handle'] = ['required', Rule::unique(Attribute::class, 'handle')->where(function ($query) {
                return $query->where('attribute_group_id', $this->group->id);
            })];
        }

        foreach ($this->languages as $lang) {
            $rules["attribute_name.{$lang->code}"] = ($lang->default ? 'required' : 'nullable') . '|string|max:255';
        }

        if ($this->getFieldType()) {
            $fieldTypeOptions = $this->getFieldTypeConfig()['options'] ?? [];

            foreach ($fieldTypeOptions as $field => $validation) {
                $rules["configuration.{$field}"] = $validation;
            }
        }

        return $rules;
    }

    protected function validationAttributes(): array
    {
        $attributes = [];

        foreach ($this->languages as $lang) {
            $attributes[".name.{$lang->code}"] = lang(key: 'inputs.name', locale: $lang->code, lower: true);
        }

        if ($this->getFieldType()) {
            $fieldTypeOptions = $this->getFieldTypeConfig()['options'] ?? [];

            foreach ($fieldTypeOptions as $field => $validation) {
                $attributes["configuration.{$field}"] = lang(key: "inputs.{$field}", locale: $this->defaultLanguage->code, lower: true);
            }
        }

        return $attributes;
    }

    /**
     * Return the available field types.
     *
     * @return Collection
     */
    public function getFieldTypesProperty(): Collection
    {
        return FieldTypeManifest::getTypes();
    }

    /**
     * Return the selected field type.
     */
    public function getFieldType()
    {
        return app()->make($this->attribute_type);
    }
    /**
     * Return the config for the field type.
     *
     * @return array|null
     */
    public function getFieldTypeConfig(): array|null
    {
        return $this->getFieldType()?->getConfig() ?: null;
    }

    /**
     * Format the handle on update to a slug.
     *
     * @return void
     */
    public function updatedAttributeHandle(): void
    {
        $this->attribute->handle = Str::handle($this->attribute->handle);
    }

    public function formatHandle(): void
    {
        if (!$this->manualHandle && !$this->attribute->handle) {
            $this->handle = Str::handle(
                $this->attribute_name[$this->defaultLanguage->code] ?? null
            );
        }
    }

    /**
     * Save the attribute.
     *
     * @return void
     */
    public function save(): void
    {
        $this->validate();

        $this->attribute->name = $this->attribute_name;
        $this->attribute->handle = $this->handle;
        $this->attribute->section = $this->section;
        $this->attribute->type = $this->attribute_type;
        $this->attribute->required = $this->required;
        $this->attribute->configuration = $this->configuration;
        $this->attribute->validation_rules = $this->validation_rules;
        $this->attribute->system = $this->system;
        $this->attribute->filterable = $this->filterable;
        $this->attribute->searchable = $this->searchable;

        if (!$this->attribute->id) {
            $this->attribute->attribute_type = $this->group->attributable_type;
            $this->attribute->attribute_group_id = $this->group->id;

            $this->attribute->position = Attribute::whereAttributeGroupId(
                $this->group->id
            )->count() + 1;
            $this->attribute->save();
            // Toast
            $this->toast(
                type: 'success',
                title: __('admin.attributes.create_success')
            );
            $this->dispatch('attribute-edit.created', $this->attribute->id);
            $this->flushCache();
            return;
        }

        $this->attribute->save();
        // Toast
        $this->toast(
            type: 'success',
            title: __('admin.attributes.update_success')
        );
        $this->dispatch('attribute-edit.updated', $this->attribute->id);
        $this->flushCache();
    }


    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.settings.attributes.attribute-edit');
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
