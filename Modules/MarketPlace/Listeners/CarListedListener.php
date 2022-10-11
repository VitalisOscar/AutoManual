<?php

namespace Modules\MarketPlace\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MarketPlace\Events\CarListedEvent;

class CarListedListener
{
    /**
     * @param CarListedEvent $event
     */
    public function handle($event): void
    {

    }
}
