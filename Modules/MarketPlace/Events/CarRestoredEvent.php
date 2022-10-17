<?php

namespace Modules\MarketPlace\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\MarketPlace\Models\Car;

class CarRestoredEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var Car
     */
    public $car;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($car)
    {
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
