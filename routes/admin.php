<?php

use App\Http\Controllers\Admin\Admins\RoleController;
use App\Http\Controllers\Admin\Admins\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BackEndController;
use App\Http\Controllers\Admin\Medias\MediaController;
use App\Http\Controllers\Admin\Settings\AttributeController;
use App\Http\Middleware\AdministrationAccess;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'login'])->name('login'); // Login Page
Route::get('password/forget', [AuthController::class, 'password'])->name('password'); // Forgot password
Route::get('logout', [AuthController::class, 'logout'])->name('logout'); // Logout

Route::middleware(['web', AdministrationAccess::class])->group(function (): void {
    Route::get('/', [BackEndController::class, 'dashboard'])->name('dashboard'); // Dashboard
    Route::get('storage-link', [BackEndController::class, 'storage_link'])->name('storage.link'); // Storage Link
    Route::get('update-migrations', [BackEndController::class, 'update_migrations'])->name('update_migrations'); // Update migrations
    // Administrators
    Route::group(['prefix' => 'administrators'], function (): void {
        crud_route(uri: 'users', controller: UserController::class, name: 'admins.users'); // Administrators : Users
        crud_route(uri: 'roles', controller: RoleController::class, name: 'admins.roles'); // Administrators : Roles
    });
    // Medias
    Route::prefix('medias')->group(function (): void {
        Route::get('delete/{uuid}', [MediaController::class, 'destroy'])->where(['uuid' => '[a-z-0-9\-]+'])->name('medias.destroy'); // Media : Delete
        Route::post('chunk-upload/{field}', [MediaController::class, 'uploadFile'])->name('chunk.upload'); // Media : Chunk Upload
    });
    // Settings
    Route::group([
        'prefix' => 'settings',
    ], function (): void {
        Route::get('attributes', [AttributeController::class, 'index'])->name('settings.attributes.index'); // Attributes
        Route::get('attributes/{slug}', [AttributeController::class, 'edit'])->where(['slug' => '[a-z]+'])->name('settings.attributes.edit'); // Attributes : edit
    });
});
