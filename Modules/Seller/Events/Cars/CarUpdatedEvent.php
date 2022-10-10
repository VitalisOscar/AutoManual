<?php

namespace Modules\Seller\Events\Cars;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Seller\Models\Car;

class CarUpdatedEvent
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
