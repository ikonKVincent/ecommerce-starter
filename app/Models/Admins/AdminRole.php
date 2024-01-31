<?php

namespace App\Models\Admins;

use App\Base\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AdminRole extends Model
{
    use HasFactory,
        HasUlids,
        QueryCacheable;

    public $cacheFor = 604800;

    public $cachePrefix = 'admin_role_';

    public $fillable = [
        'name',
    ];

    public $incrementing = false;

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Return the admins relationship.
     * @return HasMany
     */
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id', 'id');
    }

    /**
     * Return the permissions relationship.
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(AdminPermission::class, 'role_id', 'id');
    }
}
