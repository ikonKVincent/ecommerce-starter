<?php

namespace App\Http\Controllers\Admin\Admins;

use App\Actions\Admin\Admins\UserActions;
use App\Http\Controllers\AdminCrudController;
use App\Http\Requests\Admin\Admins\UserStoreRequest;
use App\Http\Requests\Admin\Admins\UserUpdateRequest;
use App\Models\Admins\Admin;
use App\Models\Admins\AdminRole;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends AdminCrudController
{
    /**
     * Set Model for CRUD operations
     * @return void
     */
    public function setModel(): void
    {
        $this->model = Admin::class;
    }

    /**
     * Set route for CRUD operations
     * @return void
     */
    public function setRoute(): void
    {
        $this->route = 'admin.admins.users.';
    }

    /**
     * Set view for CRUD operations
     * @return void
     */
    public function setView(): void
    {
        $this->view = 'admin.admins.users.';
    }

    /**
     * Administrators List
     * @return View
     */
    public function index(): View|Response
    {
        // Policy
        if (Gate::denies('view', Admin::class)) {
            return $this->notAuthorized();
        }

        // View
        return view($this->view . '.index', [
            'seo_title' => __('admin.admins.users.title') . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.users.description') . ' | ' . env('APP_NAME'),
            'route' => $this->route,
            'seo_robot' => false,
        ]);
    }

    /**
     * Create an administrator
     */
    public function create(): View|Response
    {
        // Policy
        if (Gate::denies('create', Admin::class)) {
            return $this->notAuthorized();
        }

        // View
        return view($this->view . 'form', [
            'seo_title' => __('admin.admins.users.create') . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.users.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'admin' => new Admin(),
            'adminRoles' => $this->getAdminRoles(),
        ]);
    }

    /**
     * Create an administrator
     * @param UserStoreRequest $request
     * @param UserStoreAction $userStoreAction
     *
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request, UserActions $userActions): RedirectResponse
    {
        $admin = $userActions->store(request: $request);
        session()->flash('success', __('admin.admins.users.create_success'));
        return redirect($this->route_admin(request: $request, data: $admin));
    }

    /**
     * Edit an administrator
     */
    public function edit(string $id): View|Response|RedirectResponse
    {
        // Policy
        if (Gate::denies('edit', Admin::class)) {
            return $this->notAuthorized();
        }
        // Admin
        $admin = Admin::where('id', $id)->first();
        if (!$admin) {
            session()->flash('error', __('admin.admins.users.edit_error'));
            return redirect()->route($this->route . 'index');
        }

        // View
        return view($this->view . 'form', [
            'seo_title' => __('admin.admins.users.edit', ['name' => $admin->displayName()]) . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.users.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'admin' => $admin,
            'adminRoles' => $this->getAdminRoles(),
        ]);
    }

    /**
     * Update an administrator
     * @param UserUpdateRequest $request
     * @param string $id
     * @param UserActions $userActions
     *
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, string $id, UserActions $userActions): RedirectResponse
    {
        // Admin
        $admin = Admin::where('id', $id)->first();
        if (!$admin) {
            session()->flash('error', __('admin.admins.users.edit_error'));
            return redirect()->route($this->route . 'index');
        }
        $admin = $userActions->update(admin: $admin, request: $request);
        // Medias alt
        if ($request->input('alt')) {
            $this->edit_alt($request->input('alt'));
        }
        // Logout if disable account
        if ($admin->id == Auth::guard('admin')->user()->id && !$admin->enabled) {
            return redirect()->route('admin.logout');
        }
        session()->flash('success', __('admin.admins.users.update_success'));
        return redirect($this->route_admin(request: $request, data: $admin));
    }

    /**
     * Delete an administrator
     * @param string $id
     * @param UserActions $userActions
     *
     * @return RedirectResponse
     */
    public function destroy(string $id, UserActions $userActions): RedirectResponse|Response
    {
        // Policy
        if (Gate::denies('delete', Admin::class)) {
            return $this->notAuthorized();
        }
        // Admin
        $admin = Admin::where('id', $id)->first();
        if (!$admin) {
            session()->flash('error', __('admin.admins.users.edit_error'));
            return redirect()->route($this->route . 'index');
        }
        $userActions->delete(admin: $admin);
        if ($admin->id == Auth::guard('admin')->user()->id && !$admin->enabled) {
            return redirect()->route('admin.logout');
        }
        session()->flash('success', __('admin.admins.users.delete_success'));
        return redirect()->route($this->route . 'index');
    }

    /**
     * Get admins roles
     * @return array
     */
    private function getAdminRoles(): array
    {
        return AdminRole::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->map(fn ($role) => $role->name)
            ->toArray();
    }
}
