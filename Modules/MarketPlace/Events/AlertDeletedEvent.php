<?php

namespace Modules\MarketPlace\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\MarketPlace\Models\Alert;

class AlertDeletedEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var Alert
     */
    public $alert;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
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
