<?php

namespace Modules\MarketPlace\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FavoriteRemovedEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Car
     */
    public $car;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $car)
    {
        $this->user = $user;
        $this->car = $car;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
