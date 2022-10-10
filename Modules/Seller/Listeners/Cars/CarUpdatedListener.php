<?php

namespace Modules\Seller\Listeners\Cars;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Seller\Events\Cars\CarUpdatedEvent;

class CarUpdatedListener
{
    /**
     * @param CarUpdatedEvent $event
     */
    public function handle($event): void
    {

    }
}
