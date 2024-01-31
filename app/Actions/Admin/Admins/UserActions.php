<?php

namespace App\Actions\Admin\Admins;

use App\Models\Admins\Admin;
use App\Traits\Crud\FileUploadValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UserActions
{
    use FileUploadValidationTrait;

    /**
     * Create admin action
     *
     * @param Request $request
     *
     * @return Admin
     */
    public function store(Request $request): Admin
    {
        // Create Admin
        $admin = Admin::create([
            'enabled' => $request->input('enabled') ? true : false,
            'role_id' => $request->input('role_id'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => bcrypt(trim($request->input('password'))),
        ]);
        // Avatar
        if ($request->input('avatar_file')) {
            $this->uploadAvatar(admin: $admin, avatar: $request->input('avatar_file'));
        }
        return $admin;
    }

    /**
     * Update admin action
     *
     * @param Admin $admin
     * @param Request $request
     *
     * @return Admin
     */
    public function update(Admin $admin, Request $request): Admin
    {
        $update = [
            'enabled' => $request->input('enabled') ? true : false,
            'role_id' => $request->input('role_id'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
        ];
        if ($request->password) {
            $update['password'] = bcrypt(trim($request->input('password')));
        }
        $admin->update($update);
        // Avatar
        if ($request->input('avatar_file')) {
            $this->uploadAvatar(admin: $admin, avatar: $request->input('avatar_file'));
        }
        return $admin;
    }

    /**
     * Delete admin action
     *
     * @param Admin $admin
     *
     * @return void
     */
    public function delete(Admin $admin): void
    {
        $admin->delete();
    }

    /**
     * Upload admin avatar to avatar collection
     *
     * @param Admin $admin
     * @param string $avatar
     *
     * @return void
     */
    private function uploadAvatar(Admin $admin, string $avatar): void
    {
        $admin->clearMediaCollection('avatar');
        $avatarFiles = explode(',', str_replace('[', '', str_replace(']', '', str_replace('"', '', $avatar))));
        if (!empty($avatarFiles)) {
            foreach ($avatarFiles as $avatarFile) {
                $filePath = storage_path('app/public/' . $avatarFile);
                if (file_exists($filePath)) {
                    $admin->addMedia($filePath)->toMediaCollection('avatar');
                }
            }
        }
    }
}
