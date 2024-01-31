<?php

namespace App\Traits\Crud;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Base\FieldTypes\File;
use App\Base\FieldTypes\Number;
use App\Base\FieldTypes\Text;
use App\Base\FieldTypes\TranslatedText;
use App\Models\Medias\Asset;
use App\Models\Settings\AttributeGroup;

trait WithAttributes
{
    public ?Collection $attributeGroups = null;

    public array $attributesMapping = [];

    /**
     * Get Model's Attributes
     * @param string $model
     * @param Model $data
     *
     * @return void
     */
    public function getAttributes(string $model, Model $data): void
    {
        $this->attributeGroups = AttributeGroup::query()
            ->whereAttributableType($model)
            ->with(['attributes'])
            ->orderBy('position', 'asc')
            ->get();
        $this->parseAttributes($data->attribute_data);
    }

    /**
     * Parse attributes & values
     * @param Collection|null $existingData
     * @param string $key
     *
     * @return void
     */
    public function parseAttributes(?Collection $existingData = null, string $key = 'attributesMapping'): void
    {
        if ($this->attributeGroups) {
            foreach ($this->attributeGroups as $group) {
                if (!$group->attributes->isEmpty()) {
                    foreach ($group->attributes as $attribute) {
                        if (class_exists($attribute->type)) {
                            $data = $existingData ? $existingData->first(fn ($value, $handle) => $handle === $attribute->slug) : null;
                            if (is_array($data)) {
                                $data = collect($data);
                            }
                            $value = $data ? $data->getValue() : null;
                            if (TranslatedText::class === $attribute->type) {
                                $value = $this->prepareTranslatedText($value);
                            }
                            $reference = 'a_' . $attribute->id;
                            $this->attributesMapping[$reference] = [
                                'id' => $attribute->slug,
                                'group' => $group->name,
                                'group_id' => $group->id,
                                'name' => $attribute->name,
                                'signature' => $reference,
                                'type' => $attribute->type,
                                'handle' => $attribute->slug,
                                'configuration' => $attribute->configuration,
                                'required' => $attribute->required,
                                'system' => $attribute->system,
                                'view' => app()->make($attribute->type)->getView(),
                                'data' => $value,
                            ];
                        }
                    }
                }
            }
        }
    }

    /**
     * Prepare Attribute Data
     * @param array $attributes
     * @param Request $request
     *
     * @return Collection
     */
    public function prepareAttributeData(array $attributes, Request $request): Collection
    {
        return collect($attributes)->mapWithKeys(function ($attribute_data, $attribute_key) use ($request) {

            $value = null;
            if (isset($this->attributesMapping[$attribute_key], $this->attributesMapping[$attribute_key]['type'])) {

                switch ($this->attributesMapping[$attribute_key]['type']) {
                    case TranslatedText::class:
                        $value = $this->mapTranslatedText($attribute_data);
                        break;
                    case File::class:
                        // File upload
                        if ($request->hasFile('attributes.' . $attribute_key)) {
                            $asset = Asset::create();
                            if (isset($this->attributesMapping[$attribute_key]['configuration']['max_files']) && $this->attributesMapping[$attribute_key]['configuration']['max_files'] > 1) {
                                if ($request->hasFile($attribute_key)) {
                                    $asset->addMultipleMediaFromRequest(['attributes.' . $attribute_key])->each(function ($fileAdder): void {
                                        $fileAdder->toMediaCollection('upload');
                                    });
                                }
                            } else {
                                $asset->clearMediaCollection('attributes.' . $attribute_key);
                                $asset->addMediaFromRequest('attributes.' . $attribute_key)->toMediaCollection('upload');
                            }
                            $value = new $this->attributesMapping[$attribute_key]['type']($asset->file);
                            break;
                        }
                        $attribute_value = json_decode($attribute_data);
                        if (is_array($attribute_value)) {
                            $attribute_value = $attribute_value[0];
                        }
                        $value = new $this->attributesMapping[$attribute_key]['type']($attribute_value);
                        break;

                    default:
                        $value = new $this->attributesMapping[$attribute_key]['type']($attribute_data);
                        break;
                }

                return [
                    $this->attributesMapping[$attribute_key]['handle'] => $value,
                ];
            }
        });
    }

    /**
     * Attributes validation
     *
     * @return array
     */
    public function withAttributesValidationRules(): array
    {
        $rules = [];
        foreach ($this->attributesMapping as $attribute) {
            if (!class_exists($attribute['type'])) {
                continue;
            }
            $field = $attribute['signature'];
            $isRequired = ($attribute['required'] ?? false) || ($attribute['system'] ?? false);

            if (TranslatedText::class === $attribute['type']) {
                foreach ($this->languages as $language) {
                    $validationRules = [];
                    if ($language->default) {
                        if ($isRequired) {
                            $validationRules = array_merge($validationRules, ['required']);
                        }
                    }
                    if (!empty($validationRules)) {
                        $rules["{$attribute['signature']}.{$language->code}"] = $validationRules;
                    }
                }

                continue;
            }
            $validation = [];
            if ($isRequired) {
                $validation = ['required'];
            }

            if (Number::class === $attribute['type']) {
                $validation = array_merge($validation, [
                    'numeric' . ($attribute['configuration']['min'] ? '|min:' . $attribute['configuration']['min'] : ''),
                    'numeric' . ($attribute['configuration']['max'] ? '|max:' . $attribute['configuration']['max'] : ''),
                ]);
            }
            if (!empty($validation)) {
                $rules[$field] = implode('|', $validation);
            }
        }

        return $rules;
    }


    /**
     * Map translate text
     * @param mixed $data
     *
     * @return TranslatedText
     */
    protected function mapTranslatedText($data): TranslatedText
    {
        $values = [];
        foreach ($data as $code => $value) {
            $values[$code] = new Text($value);
        }

        return new TranslatedText(collect($values));
    }

    /**
     * Prepare translated text field for Livewire modeling.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    protected function prepareTranslatedText(mixed $value): mixed
    {
        foreach ($this->languages as $language) {
            if (is_string($value)) {
                $newValue = collect();
                if ($language->default) {
                    $newValue[$language->code] = $value;
                }
                $value = $newValue;

                continue;
            }

            if (empty($value[$language->code])) {
                $value[$language->code] = null;
            }
        }

        return $value;
    }

    /**
     * Return validation messages.
     * @param string $key
     *
     * @return array
     */
    protected function withAttributesValidationMessages(string $key = 'attributesMapping'): array
    {
        $messages = [];
        foreach ($this->attributesMapping as $index => $attribute) {
            if (($attribute['required'] ?? false) || ($attribute['system'] ?? false)) {
                if (TranslatedText::class === $attribute['type']) {
                    $messages["{$key}.{$index}.data.{$this->defaultLanguage->code}.required"] = __('admin.attributes.field_required', [
                        'name' => $attribute['name'],
                        'group' => $attribute['group'],
                    ]);

                    continue;
                }
                $messages["{$key}.{$index}.data.required"] = __('admin.attributes.field_required', [
                    'name' => $attribute['name'],
                    'group' => $attribute['group'],
                ]);
            }
        }

        return $messages;
    }
}
