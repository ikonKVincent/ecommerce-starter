<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Settings\Language;
use App\Models\Settings\Url;
use Illuminate\Database\Eloquent\Builder;

class UrlGenerator
{
    /**
     * The instance of the model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The default language.
     */
    protected Language $defaultLanguage;

    /**
     * Construct the class.
     */
    public function __construct()
    {
        $this->defaultLanguage = Language::getDefault();
    }

    /**
     * Handle the URL generation.
     *
     * @param  Model  $model
     * @return void
     */
    public function handle(Model $model): void
    {
        $this->model = $model;
        if (!$model->urls->count()) {
            if ($model->attribute_data) {
                $this->createUrl(
                    $model->attr('name')
                );

                return;
            }
            if ($name = $model->name) {
                $this->createUrl($name);
            }
        }
    }

    /**
     * Create default url from an attribute.
     *
     * @param  string  $value
     * @return void
     */
    protected function createUrl(string $value): void
    {
        $uniqueSlug = $this->getUniqueSlug(Str::slug($value));

        $this->model->urls()->create([
            'default' => true,
            'language_id' => $this->defaultLanguage->id,
            'slug' => $uniqueSlug,
        ]);
    }

    /**
     * Generates unique slug based on the given slug by adding suffix numbers.
     *
     * @param  string  $slug
     * @return string
     */
    private function getUniqueSlug(string $slug): string
    {
        $separator = config('akawam.urls.separator');
        $slugs = $this->getExistingSlugs($slug, $separator);
        if (!$slugs->count() || $slugs->contains($slug) === false) {
            return $slug;
        }
        if ($slugs->has($this->model->getKey())) {
            $currentSlug = $slugs->get($this->model->getKey());
            if ($currentSlug === $slug || str_starts_with($currentSlug, $slug)) {
                return $currentSlug;
            }
        }
        $suffix = $this->getSuffix($slug, $separator, $slugs);

        return $slug . $separator . $suffix;
    }

    /**
     * Get all urls similar to the given slug.
     *
     * @param  string  $slug
     * @param  string  $separator
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getExistingSlugs(string $slug, string $separator): Collection
    {
        return Url::where(function (Builder $query) use ($slug, $separator): void {
            $query->where('slug', $slug)
                ->orWhere('slug', 'like', $slug . $separator . '%');
        })->where('language_id', $this->defaultLanguage->id)
            ->select(['element_id', 'slug'])
            ->get()
            ->toBase()
            ->pluck('slug', 'element_id');
    }

    /**
     * @param  string  $slug
     * @param  string  $separator
     * @param  Collection  $slugs
     * @return string
     */
    private function getSuffix(string $slug, string $separator, Collection $slugs): string
    {
        $len = strlen($slug . $separator);
        if ($slugs->search($slug) === $this->model->getKey()) {
            $suffix = explode($separator, $slug);

            return end($suffix);
        }
        $slugs->transform(function ($value, $key) use ($len) {
            return (int) substr($value, $len);
        });
        $max = $slugs->max();
        return (string) ($max === 0 ? 2 : $max + 1);
    }
}
