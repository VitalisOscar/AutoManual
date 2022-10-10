<?php

namespace Modules\Seller\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Seller\Events\Cars\CarListedEvent;
use Modules\Seller\Events\Cars\CarUpdatedEvent;
use Modules\Seller\Events\SellerCreatedEvent;
use Modules\Seller\Listeners\Cars\CarListedListener;
use Modules\Seller\Listeners\Cars\CarUpdatedListener;
use Modules\Seller\Listeners\SellerCreatedListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        SellerCreatedEvent::class => [
            SellerCreatedListener::class,
        ],
        CarListedEvent::class => [
            CarListedListener::class,
        ],
        CarUpdatedEvent::class => [
            CarUpdatedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
