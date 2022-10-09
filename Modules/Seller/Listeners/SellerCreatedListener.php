<?php

namespace Modules\Seller\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Seller\Events\SellerCreatedEvent;

class SellerCreatedListener
{
    /**
     * @param SellerCreatedEvent $event
     */
    public function handle($event): void
    {

    }
}
