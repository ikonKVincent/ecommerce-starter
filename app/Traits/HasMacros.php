<?php

namespace App\Traits;

use Illuminate\Support\Traits\Macroable;

trait HasMacros
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters): mixed
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters): mixed
    {
        return parent::__callStatic($method, $parameters);
    }
}
