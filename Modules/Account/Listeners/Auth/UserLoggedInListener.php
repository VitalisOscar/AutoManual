<?php

namespace Modules\Account\Listeners\Auth;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Account\Events\Auth\UserLoggedInEvent;

class UserLoggedInListener
{
    /**
     * @param UserLoggedInEvent $event
     */
    public function handle($event): void
    {

    }
}
