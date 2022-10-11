<?php

namespace Modules\MarketPlace\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\MarketPlace\Models\Car;

class CarListedEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var Car
     */
    public $car;

    public function __construct($car)
    {
        $this->car = $car;
    }

    public function broadcastOn(): array
    {
        return [];
    }
}
