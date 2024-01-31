<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Admins\Admin;
use App\Models\Settings\Attribute;
use App\Policies\Admin\Admins\AdminUserPolicy;
use App\Policies\Admin\Settings\AttributePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Admin
        Admin::class => AdminUserPolicy::class,
        // Attribute
        Attribute::class => AttributePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}
