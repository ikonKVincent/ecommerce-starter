<?php

namespace App\Models\Admins;

use App\Base\Medias\AvatarMediaConversion;
use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\MediaLibrary\HasMedia as MediaLibraryHasMedia;

class Admin extends Authenticatable implements MediaLibraryHasMedia
{
    use HasFactory,
        HasMedia,
        HasUlids,
        Notifiable,
        QueryCacheable,
        SoftDeletes;

    public $cacheFor = 604800;

    public $cachePrefix = 'admin_';

    public $incrementing = false;

    protected $casts = [
        'enabled' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'enabled',
        'role_id',
        'firstname',
        'lastname',
        'password',
        'email',
    ];

    protected $hidden = [
        'password'
    ];

    protected static $flushCacheOnUpdate = true;

    protected $keyType = 'string';

    /**
     * Disable admin
     *
     * @return bool
     */
    public function disable(): bool
    {
        $this->enabled = 0;

        return $this->save();
    }

    /**
     * Get admin full name.
     *
     * @return string
     */
    public function displayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * Get admin full name inital.
     *
     * @return string
     */
    public function displayNameInitial(): string
    {
        return Str::upper(substr($this->firstname, 0, 1) . substr($this->lastname, 0, 1));
    }

    /**
     * Return the role relationship.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class, 'role_id', 'id');
    }

    /**
     * Set Media Conversions
     *
     * @return array
     */
    protected function setConversionClasses(): array
    {
        return [
            AvatarMediaConversion::class,
        ];
    }
}
