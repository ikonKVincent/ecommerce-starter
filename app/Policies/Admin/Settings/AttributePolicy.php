<?php

namespace App\Policies\Admin\Settings;

use App\Traits\CrudPolicies;

class AttributePolicy
{
    use CrudPolicies;

    protected string $module = 'Paramètres : Attributs';
}
