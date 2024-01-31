<?php

namespace App\Traits;

use App\Models\Admins\Admin;
use App\Models\Admins\AdminPermission;
use Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

trait CrudPolicies
{
    use HandlesAuthorization;

    /**
     * Create permission
     */
    public function create(Admin $admin): bool
    {
        if (!$this->module) {
            return new Exception(message: 'Veuillez paramètrer le module pour ce Policy');
        }
        if ($admin->role->name === config('akawam.admin.superAdmin')) {
            return true;
        }
        $permission = AdminPermission::query()
            ->where('name', $this->module)
            ->where('action', 'create')
            ->where('role_id', $admin->role->id)
            ->first();

        return (bool) ($permission);
    }

    /**
     * Delete permission
     */
    public function delete(Admin $admin): bool
    {
        if (!$this->module) {
            return new Exception(message: 'Veuillez paramètrer le module pour ce Policy');
        }
        if ($admin->role->name === config('akawam.admin.superAdmin')) {
            return true;
        }
        $permission = AdminPermission::query()
            ->where('name', $this->module)
            ->where('action', 'delete')
            ->where('role_id', $admin->role->id)
            ->first();

        return (bool) ($permission);
    }

    /**
     * update permission
     */
    public function edit(Admin $admin): bool
    {
        if (!$this->module) {
            return new Exception(message: 'Veuillez paramètrer le module pour ce Policy');
        }
        if ($admin->role->name === config('akawam.admin.superAdmin')) {
            return true;
        }
        $permission = AdminPermission::query()
            ->where('name', $this->module)
            ->where('action', 'edit')
            ->where('role_id', $admin->role->id)
            ->first();

        return (bool) ($permission);
    }

    /**
     * View permission
     */
    public function view(Admin $admin): bool
    {
        if (!$this->module) {
            return new Exception(message: 'Veuillez paramètrer le module pour ce Policy');
        }
        if ($admin->role->name === config('akawam.admin.superAdmin')) {
            return true;
        }
        $permission = AdminPermission::query()
            ->where('name', $this->module)
            ->where('action', 'view')
            ->where('role_id', $admin->role->id)
            ->first();

        return (bool) ($permission);
    }
}
