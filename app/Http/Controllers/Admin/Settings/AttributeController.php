<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\AdminCrudController;
use App\Models\Settings\Attribute;
use App\Models\Settings\AttributeGroup;
use App\Traits\Crud\WithFieldTypes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class AttributeController extends AdminCrudController
{
    use WithFieldTypes;

    /**
     * Set Model for CRUD operations
     */
    public function setModel(): void
    {
        $this->model = AttributeGroup::class;
    }

    /**
     * Set route for CRUD operations
     */
    public function setRoute(): void
    {
        $this->route = 'admin.settings.attributes.';
    }

    /**
     * Set view for CRUD operations
     */
    public function setView(): void
    {
        $this->view = 'admin.settings.attributes.';
    }

    /**
     * Attributes Model list
     * @return View
     */
    public function index(): View|Response
    {
        // Authorize
        if (Gate::denies('view', Attribute::class)) {
            return $this->notAuthorized();
        }

        $types = config('akawam.attributes.models_for_attributes');
        $datas = collect($types)->map(function ($type, $index) {
            $groups = AttributeGroup::whereAttributableType($type)->get();
            $class = class_basename($type);

            return (object) [
                'class' => $class,
                'slug' => Str::slug($class),
                'handle' => $index,
                'group_count' => $groups->count(),
                'attribute_count' => Attribute::query()->whereIn(
                    'attribute_group_id',
                    $groups->pluck('id')->toArray()
                )->count(),
            ];
        });
        // View
        return view($this->view . 'index', [
            'seo_title' => __('admin.settings.attributes.title') . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.settings.attributes.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'datas' => $datas,
        ]);
    }

    /**
     * Edit attributes for Model
     *
     * @param string $slug
     *
     * @return View
     */
    public function edit(string $slug): View|RedirectResponse|Response
    {
        // Authorize
        if (Gate::denies('edit', Attribute::class)) {
            return $this->notAuthorized();
        }
        if (!array_key_exists($slug, config('akawam.attributes.models_for_attributes'))) {
            session()->flash('error', __('admin.settings.attributes.edit_error'));
            return redirect()->route($this->route . 'index');
        }
        $type = config('akawam.attributes.models_for_attributes')[$slug];
        $title = __('admin.settings.attributes.edit', ['name' => class_basename($type)]);
        // View
        return view($this->view . 'form', [
            'seo_title' => $title . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.settings.attributes.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'title' => $title,
            'slug' => $slug,
            'type' => $type,
        ]);
    }
}
