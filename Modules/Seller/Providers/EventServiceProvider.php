<?php

namespace Modules\Seller\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Seller\Events\SellerCreatedEvent;
use Modules\Seller\Listeners\SellerCreatedListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        SellerCreatedEvent::class => [
            SellerCreatedListener::class,
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
