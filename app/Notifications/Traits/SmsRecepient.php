<?php

namespace App\Notifications\Traits;

trait SmsRecepient{

    /**
     * Get the phone number to receive an SMS message
     *
     * @return string
     */
    function getSmsPhoneNumber(){
        return $this->phone;
    }

}
