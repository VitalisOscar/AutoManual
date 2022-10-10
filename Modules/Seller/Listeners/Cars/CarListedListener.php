<?php

namespace Modules\Seller\Listeners\Cars;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Seller\Events\Cars\CarListedEvent;

class CarListedListener
{
    /**
     * @param CarListedEvent $event
     */
    public function handle($event): void
    {

    }
}
