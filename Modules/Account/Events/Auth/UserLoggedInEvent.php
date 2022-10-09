<?php

namespace Modules\Account\Events\Auth;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Account\Models\User;

class UserLoggedInEvent
{
    use SerializesModels, Dispatchable;

    /**
     * @var User
     */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [];
    }
}
