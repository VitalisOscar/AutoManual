<?php

namespace Modules\Account\Listeners\Auth;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Account\Events\Auth\PhoneVerifiedEvent;

class PhoneVerifiedListener
{
    /**
     * @param PhoneVerifiedEvent $event
     */
    public function handle($event): void
    {

    }
}
