<?php

namespace App\Actions\Admin\Admins;

use App\Models\Admins\Admin;
use App\Models\Admins\AdminPermission;
use App\Models\Admins\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleActions
{

    /**
     * Create admin action
     *
     * @param Request $request
     *
     * @return AdminRole
     */
    public function store(Request $request): AdminRole
    {
        $role = AdminRole::create([
            'name' => $request->name,
        ]);
        // Permissions
        if ($request->input('permissions')) {
            $this->savePermissions(role: $role, permissions: $request->input('permissions'));
        }

        return $role;
    }

    /**
     * Update admin action
     *
     * @param AdminRole $admin
     * @param Request $request
     *
     * @return AdminRole
     */
    public function update(AdminRole $role, Request $request): AdminRole
    {
        $role->update([
            'name' => $request->input('name')
        ]);
        // Permissions
        if ($request->input('permissions')) {
            $this->savePermissions(role: $role, permissions: $request->input('permissions'));
        }
        return $role;
    }

    /**
     * Delete admin role action
     *
     * @param AdminRole $role
     *
     * @return void
     */
    public function delete(AdminRole $role): void
    {
        $admins = $role->admins->pluck('id')->toArray();
        if (!empty($admins)) {
            $defaultRole = AdminRole::query()->select('id')->orderBy('created', 'desc')->first();
            if ($defaultRole) {
                Admin::whereIn('id', $admins)->update([
                    'role_id' => $defaultRole->id
                ]);
            }
        }
        $role->delete();
    }

    private function savePermissions(AdminRole $role, array $permissions): void
    {
        $insert = [];
        $now = now();
        foreach ($permissions as $section => $modules) {
            if (!empty($modules)) {
                foreach ($modules as $module => $actions) {
                    if (!empty($actions)) {
                        foreach ($actions as $action => $value) {
                            $insert[] = [
                                'id' => Str::lower(Str::ulid()->toBase32()),
                                'role_id' => $role->id,
                                'name' => $section . ' : ' . $module,
                                'action' => $action,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }
        }
        AdminPermission::where('role_id', $role->id)->delete();
        if (!empty($insert)) {
            AdminPermission::insert($insert);
        }
        AdminPermission::flushQueryCache();
    }
}
