<?php

namespace Modules\Account\Listeners\Auth;

use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Account\Events\Auth\UserRegisteredEvent;
use Modules\Account\Notifications\VerifyCodeNotification;

class UserRegisteredListener
{
    /**
     * @param UserRegisteredEvent $event
     */
    public function handle($event): void
    {
        // Send a phone verification code to the user's phone
        try{
            $user = $event->user;
            $notification = new VerifyCodeNotification($user, 'phone_verification');

            $user->notify($notification);

        }catch(Exception $e){

        }
    }
}
