<?php

namespace App\Http\Controllers\Admin\Admins;

use App\Actions\Admin\Admins\RoleActions;
use App\Http\Controllers\AdminCrudController;
use App\Http\Requests\Admin\Admins\RoleStoreRequest;
use App\Http\Requests\Admin\Admins\RoleUpdateRequest;
use App\Models\Admins\Admin;
use App\Models\Admins\AdminRole;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class RoleController extends AdminCrudController
{
    /**
     * Set Model for CRUD operations
     * @return void
     */
    public function setModel(): void
    {
        $this->model = AdminRole::class;
    }

    /**
     * Set route for CRUD operations
     * @return void
     */
    public function setRoute(): void
    {
        $this->route = 'admin.admins.roles.';
    }

    /**
     * Set view for CRUD operations
     * @return void
     */
    public function setView(): void
    {
        $this->view = 'admin.admins.roles.';
    }

    /**
     * Roles List
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
            'seo_title' => __('admin.admins.roles.title') . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.roles.description') . ' | ' . env('APP_NAME'),
            'route' => $this->route,
            'seo_robot' => false,
        ]);
    }

    /**
     * Create a role
     */
    public function create(): View|Response
    {
        // Policy
        if (Gate::denies('create', Admin::class)) {
            return $this->notAuthorized();
        }
        $role = new AdminRole();
        // View
        return view($this->view . 'form', [
            'seo_title' => __('admin.admins.roles.create') . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.roles.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'role' => $role,
            'permissions' => $this->getPermissions($role)
        ]);
    }

    /**
     * Create an administrator role
     * @param RoleStoreRequest $request
     * @param RoleActions $userStoreAction
     *
     * @return RedirectResponse|Response
     */
    public function store(RoleStoreRequest $request, RoleActions $roleActions): RedirectResponse
    {
        $role = $roleActions->store(request: $request);
        session()->flash('success', __('admin.admins.roles.create_success'));
        return redirect($this->route_admin(request: $request, data: $role));
    }

    /**
     * Edit an administrator role
     */
    public function edit(string $id): View|Response|RedirectResponse
    {
        // Policy
        if (Gate::denies('edit', Admin::class)) {
            return $this->notAuthorized();
        }

        // Role
        $role = AdminRole::where('id', $id)->first();
        if (!$role) {
            session()->flash('error', __('admin.admins.roles.edit_error'));
            return redirect()->route($this->route . 'index');
        }

        // View
        return view($this->view . 'form', [
            'seo_title' => __('admin.admins.users.edit', ['name' => $role->name]) . ' | ' . env('APP_NAME'),
            'seo_description' => __('admin.admins.users.description') . ' | ' . env('APP_NAME'),
            'seo_robot' => false,
            'route' => $this->route,
            'role' => $role,
            'permissions' => $this->getPermissions($role)
        ]);
    }

    /**
     * Update an administrator role
     * @param RoleUpdateRequest $request
     * @param string $id
     * @param RoleActions $userActions
     *
     * @return RedirectResponse|Response
     */
    public function update(RoleUpdateRequest $request, string $id, RoleActions $roleActions): RedirectResponse|Response
    {
        // Role
        $role = AdminRole::where('id', $id)->first();
        if (!$role) {
            session()->flash('error', __('admin.admins.roles.edit_error'));
            return redirect()->route($this->route . 'index');
        }
        $role = $roleActions->update(role: $role, request: $request);
        session()->flash('success', __('admin.admins.roles.update_success'));
        return redirect($this->route_admin(request: $request, data: $role));
    }

    /**
     * Delete and administrator role
     * @param string $id
     * @param RoleActions $roleActions
     *
     * @return RedirectResponse
     */
    public function destroy(string $id, RoleActions $roleActions): RedirectResponse
    {
        // Policy
        if (Gate::denies('delete', Admin::class)) {
            return $this->notAuthorized();
        }
        // Role
        $role = AdminRole::where('id', $id)->first();
        if (!$role) {
            session()->flash('error', __('admin.admins.roles.edit_error'));
            return redirect()->route($this->route . 'index');
        }
        $roleActions->delete(role: $role);
        session()->flash('success', __('admin.admins.roles.delete_success'));
        return redirect()->route($this->route . 'index');
    }

    /**
     * Get role's permissions
     *
     * @param AdminRole $role
     *
     * @return array
     */
    private function getPermissions(AdminRole $role): array
    {
        $permissions = config('akawam.admin.permissions');
        $role_permissions = $role->permissions;
        if (!$role_permissions->isEmpty()) {
            foreach ($role_permissions as $role_permission) {
                $explode = explode(' : ', $role_permission->name);
                if (isset($permissions[$explode[0]][$explode[1]][$role_permission->action])) {
                    $permissions[$explode[0]][$explode[1]][$role_permission->action] = true;
                }
            }
        }
        return $permissions;
    }
}
