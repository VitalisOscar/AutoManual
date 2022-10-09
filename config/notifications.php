<?php

return [

    /*
    | SMS gateway provider to use to send sms messages
    */
    'sms_gateway' => env('SMS_GATEWAY'),

    /*
    | API configurations for sms providers
    */
    'africas_talking_username' => env('AFRICAS_TALKING_USERNAME', 'sandbox'),
    'africas_talking_api_key' => env('AFRICAS_TALKING_API_KEY', 'sandbox'),

    /*
     | Number of minutes a verification code is valid for
     */
    'verification_code_validity' => 5

];
