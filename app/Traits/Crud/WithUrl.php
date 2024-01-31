<?php

namespace App\Traits\Crud;

use App\Models\Settings\Language;
use App\Models\Settings\Url;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait WithUrl
{
    /**
     * Get all URL validation attributes
     * @param Request $request
     *
     * @return array
     */
    public function getUrlsValidationAttributes(Request $request): array
    {
        $attributes = [];
        foreach ($request->url as $key => $value) {
            $sequence = (int) $key + 1;
            $attributes["urls.{$key}.slug"] = lang(key: 'admin.url.slug', lower: true) . " #{$sequence}";
        }

        return $attributes;
    }

    /**
     * Return validation rules
     * @return array
     */
    public function hasUrlsValidationRules(): array
    {
        return [
            'urls' => 'array|min:1',
            'urls.*.slug' => 'required|max:255',
        ];
    }

    /**
     * Save Urls
     *
     * @param EloquentModel $model
     * @param array $urls
     * @param string $nameField
     *
     * @return void
     */
    public function saveUrls(EloquentModel $model, array $urls, string $nameField = 'name'): void
    {
        DB::transaction(function () use ($model, $urls): void {
            $slug = Str::slug($model->name);
            $exist_url = Url::query()->where('slug', $slug)->count();
            $defaultSlug = $slug . ($exist_url > 0 ? '-' . $exist_url : '');
            if (empty($urls)) {
                $lang = Language::query()->default()->first();
                Url::create([
                    'default' => 1,
                    'redirect' => 0,
                    'language_id' => $lang->id,
                    'slug' => $defaultSlug,
                    'old_slug' => null,
                    'entity_type' => $model->getMorphClass(),
                    'entity_id' => $model->id,
                ]);
            } else {
                $model->urls->reject(fn ($url) => collect($urls)->pluck('id')->contains($url->id))->each(fn ($url) => $url->delete());
                foreach ($urls as $index => $url) {
                    $urlModel = ($url['id'] ?? false) ? Url::find($url['id']) : new Url();
                    $urlModel->default = $url['default'] ? 1 : 0;
                    $urlModel->redirect = $url['old_slug'] ? 1 : 0;
                    $urlModel->language_id = $url['language_id'];
                    $urlModel->slug = $url['slug'] ? Str::slug($url['slug']) : $defaultSlug . '-' . $index;
                    $urlModel->old_slug = $url['old_slug'] ? Str::slug($url['old_slug']) : null;
                    $urlModel->entity_type = $model->getMorphClass();
                    $urlModel->entity_id = $model->id;
                    $urlModel->save();
                }
            }
        });
        Url::flushQueryCache();
    }

    /**
     * Validate URL
     * @param Request $request
     *
     * @return array
     */
    protected function validateUrls(Request $request): array
    {
        $rules = [];
        foreach ($request->url as $index => $url) {
            $rules["url.{$index}.slug"] = [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($url, $request): void {
                    $result = collect($request->url)->filter(function ($existing) use ($value, $url) {
                        return $existing['slug'] === $value &&
                            $existing['language_id'] === $url['language_id'];
                    })->count();

                    if ($result > 1) {
                        $fail(
                            __('admin.url.url_slug_unique')
                        );
                    }
                },
                Rule::unique(Url::class, 'slug')->where(function ($query) use ($url): void {
                    $query->where('slug', '=', $url['slug'])
                        ->where('language_id', '=', $url['language_id']);

                    if ($url['id'] ?? false) {
                        $query->where('id', '!=', $url['id']);
                    }
                }),
            ];

            $rules["url.{$index}.default"] = [
                'nullable',
                'boolean',
                function ($attribute, $value, $fail) use ($url, $request): void {
                    $result = collect($request->url)->filter(function ($existing) use ($value, $url) {
                        return $existing['default'] === $value &&
                            $existing['language_id'] === $url['language_id'];
                    })->count();

                    if ($value && $result > 1) {
                        $fail(
                            __('admin.url.url_default_unique')
                        );
                    }
                },
            ];
        }

        return $rules;
    }
}
