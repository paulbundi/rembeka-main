<?php

namespace App\Models;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\BaseResource;
use App\Pivots\WishList;
use App\traits\ScopedFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ScopedFilter;

    const STATUS_ACTIVE = 1;
    const TYPE_USER = 1;
    const TYPE_PROVIDER = 2;
    const TYPE_ADMIN = 3;
    const TYPE_CORPORATE = 4;
    const TYPE_SUPPLIER = 5;
    const TYPE_DRIVER = 6;

    const MALE = 1;
    const FEMALE = 2;

    const SMS_BLOCKED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'organization_id', 'email', 'password', 'phone', 'phone_verified',
        'device_token', 'two_factor_code', 'two_factor_expiry', 'wallet', 'account_type', 'status',
        'rating', 'return_times', 'organization_name', 'store_id', 'gender_id','sms_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'permissions',
        'liked',
        'name',
    ];

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getApiResourceClass(): string
    {
        return BaseResource::class;
    }

    /**
     * Get the api resource.
     *
     * @return string
     */
    protected static function getFormRequestClass(): string
    {
        return UserFormRequest::class;
    }

    /**
     * set fullnames.
     *
     * @return void
     */
    public function getNameAttribute()
    {
        if ($this->account_type == self::TYPE_CORPORATE) {
            return $this->organization_name;
        }

        return $this->first_name.' '. $this->last_name;
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return void
     */
    public function wishlist():BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wish_list')->using(WishList::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function addresses():HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Check whether the user can access the given permission.
     *
     * @param string $permission
     *
     * @return bool
     **/
    public function hasPermission(string $permission): bool
    {
        return Arr::get($this->permissions, $permission, false);
    }

    /**
     * Set User permission attribute value.
     *
     * @return array
     */
    public function getPermissionsAttribute(): array
    {
        if (!is_null($this->allPermissions)) {
            return $this->allPermissions;
        }
        $this->allPermissions = $this->roles->reduce(function ($permissions, $role) {
            return array_replace_recursive($permissions, is_array($role->permissions) ? $role->permissions : []);
        }, []);
        // $this->unsetRelation('roles');

        return $this->allPermissions;
    }

    /**
     * check account type
     *
     * @return bool
     */
    public function canAccessDashboard(): bool
    {
        if (auth()->user()->account_type == self::TYPE_USER) {
            return false;
        }

        return true;
    }

    /**
     * Items in wishlist.
     *
     * @return void
     */
    public function getLikedAttribute()
    {
        return  WishList::mine()->count();
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany
     */
    public function corporateUsers(): HasMany
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    /**
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function referralCode():HasOne
    {
        return $this->hasOne(Referralcode::class, 'user_id');

    }
}
