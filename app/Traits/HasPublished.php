<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasPublished
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', 1)
            ->where(function ($query): void {
                $query->orWhere('published_at', '<=', date('Y-m-d'))
                    ->orWhereNull('published_at');
            });
    }
}
