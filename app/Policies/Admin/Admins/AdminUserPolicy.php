<?php

namespace App\Policies\Admin\Admins;

use App\Traits\CrudPolicies;

class AdminUserPolicy
{
    use CrudPolicies;

    protected string $module = 'Paramètres : Administrateurs';
}
