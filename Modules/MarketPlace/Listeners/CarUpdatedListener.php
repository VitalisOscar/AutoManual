<?php

namespace Modules\MarketPlace\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MarketPlace\Events\CarUpdatedEvent;

class CarUpdatedListener
{
    /**
     * @param CarUpdatedEvent $event
     */
    public function handle($event): void
    {

    }
}
