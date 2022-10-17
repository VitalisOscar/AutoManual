<?php

namespace Modules\MarketPlace\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\MarketPlace\Events\CarDeletedEvent;
use Modules\MarketPlace\Events\CarRestoredEvent;
use Modules\MarketPlace\Events\Cars\CarListedEvent;
use Modules\MarketPlace\Events\Cars\CarUpdatedEvent;
use Modules\MarketPlace\Listeners\CarDeletedListener;
use Modules\MarketPlace\Listeners\CarRestoredListener;
use Modules\MarketPlace\Listeners\Cars\CarListedListener;
use Modules\MarketPlace\Listeners\Cars\CarUpdatedListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        CarListedEvent::class => [
            CarListedListener::class,
        ],
        CarUpdatedEvent::class => [
            CarUpdatedListener::class,
        ],
        CarDeletedEvent::class => [
            CarDeletedListener::class,
        ],
        CarRestoredEvent::class => [
            CarRestoredListener::class,
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
