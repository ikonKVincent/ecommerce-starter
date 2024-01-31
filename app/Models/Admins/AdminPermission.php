<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AdminPermission extends Model
{
    use HasFactory,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'admin_permission_';

    public $fillable = [
        'role_id',
        'name',
        'action',
    ];

    public $incrementing = false;

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Return the role relationship.
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class);
    }
}
