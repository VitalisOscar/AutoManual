<?php

namespace Modules\Account\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Account\Events\Auth\PhoneVerifiedEvent;
use Modules\Account\Events\Auth\UserLoggedInEvent;
use Modules\Account\Events\Auth\UserRegisteredEvent;
use Modules\Account\Listeners\Auth\PhoneVerifiedListener;
use Modules\Account\Listeners\Auth\UserLoggedInListener;
use Modules\Account\Listeners\Auth\UserRegisteredListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        UserRegisteredEvent::class => [
            UserRegisteredListener::class,
        ],

        UserLoggedInEvent::class => [
            UserLoggedInListener::class,
        ],

        PhoneVerifiedEvent::class => [
            PhoneVerifiedListener::class,
        ],
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
