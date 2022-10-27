<?php

namespace Modules\MarketPlace\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MarketPlace\Events\FavoriteAddedEvent;

class FavoriteAddedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param FavoriteAddedEvent $event
     * @return void
     */
    public function handle($event)
    {
        //
    }
}
