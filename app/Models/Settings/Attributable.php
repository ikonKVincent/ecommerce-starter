<?php

namespace App\Models\Settings;

use App\Base\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Attributable extends Model
{
    use HasFactory,
        HasUlids;

    public $incrementing = false;

    protected $fillable = [
        'attributable_id',
        'attributable_type',
        'attribute_id',
    ];

    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();
        self::creating(function ($query): void {
            $query->id = Str::lower(Str::ulid()->toBase32());
        });
    }
}
