<?php

namespace App\Providers;

use App\Models\EmailCampaign;
use App\Models\Group;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Provider;
use App\Models\SmsCampaign;
use App\Models\User;
use App\Observers\EmailCampaignObserver;
use App\Observers\GroupObserver;
use App\Observers\MediaObserver;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\ProviderObserver;
use App\Observers\SmsCampaignObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Media::observe(MediaObserver::class);
        Provider::observe(ProviderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
        User::observe(UserObserver::class);
        SmsCampaign::observe(SmsCampaignObserver::class);
        EmailCampaign::observe(EmailCampaignObserver::class);
        Group::observe(GroupObserver::class);
    }
}
