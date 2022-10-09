<?php

namespace App\Notifications\Traits;

trait SmsNotification{

    /**
     * Get the SMS message to send to a recepient
     *
     * @return string
     */
    abstract function getSmsMessage();

}
