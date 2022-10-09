<?php

namespace Modules\Seller\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Seller\Models\Seller;

class SellerCreatedEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var Seller
     */
    public $seller;

    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    public function broadcastOn(): array
    {
        return [];
    }
}
