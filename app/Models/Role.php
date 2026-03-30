<?php

namespace App\Models;

use App\Http\Requests\RoleFormRequest;
use App\Http\Resources\BaseResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
       'title', 'permissions', 'description',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    protected static $permissions = [
        'modules' => [
            'product-settings' => true,
            'service-settings' => true,
            'provider-settings' => true,
            'financial-transactions' => true,
            'partner-settings' => true,
            'spending' => true,
            'system-setting' => true,
        ],
        'sales' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'products' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'change_status' => true,
            'import' => true,
        ],
        'services' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'change_status' => true,
            'import' => true,

        ],
        'media' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'orders' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'remove-items' => true,
            'cancel' => true,
        ],
        'roles' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'menus' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'categories' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'coupons' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'reports' => [
            'view' => true,
        ],
        'age-groups' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'providers' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'location' => true,
            'income' => true,
            'change_status' => true,
            'publish' => true,
            'pay-provider' => true,
            'withdraw-for-provider' => true,
        ],
        'suppliers' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'location' => true,
            'income' => true,
            'change_status' => true,
            'publish' => true,
            'pay-provider' => true,
            'withdraw-for-provider' => true,
        ],
        'drivers' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'brands' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'unit-measures' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'stylist-calendar' => [
            'view' => true,
        ],
        'provider-pricing' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'change_status' => true,
        ],
        'provider-inquiries' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],

        'partners' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'change_status' => true,
        ],
        'transport-requests' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'delivery-requests' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'locations' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],

        'discounts' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'best-sellers' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'users' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'impersonate' => true,
            'change_status' => true,
            'remove-role' => true,
            'send-reset-password-link' => true,
            'transfer-funds' => true,
        ],
        'transactions' => [
            'mpesa-deposit' => true,
            'mpesa-withdraw' => true,
            'validate-top-up' => true,
            'revenue' => true,
        ],
        'stk-push' => [
            'view' => true,
            'validate' => true,
        ],
        'btoc' => [
            'wallet-reversal' => true,
        ],
        'channels' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'corporates' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'load-wallet' => true,
            'transfer-funds' => true,
            'pay-orders' => true,
            'delete' => true,
        ],
        'inquiries' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'referrals' => [
            'create' => true,
            'update' => true,
            'view' => true,
            'delete' => true,
        ],
        'news-letter' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'expense-type' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'expenses' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'wallet-audit' => [
            'view' => true,
        ],
        'sms-campaigns' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'email-campaigns' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'adverts' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
            'change_status' => true,
        ],
        'groups' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'wishlist' => [
            'view' => true,
        ],
        'customer-review' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],

        'stores' => [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ],
        'bulk-update' => [
            'view' => true,
        ]
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
        return  RoleFormRequest::class;
    }

    /**
     * get all available permissions.
     *
     * @return array
     */
    public static function getPermissions(): array
    {
        return self::$permissions;
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
