<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDefaultRecord
{
    /**
     * Return the default scope.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeDefault(Builder $query, bool $default = true): void
    {
        $query->where('default', $default);
    }

    /**
     * Get the default record.
     *
     * @return self
     */
    public static function getDefault(): self
    {
        return self::query()->default(true)->first();
    }
}
