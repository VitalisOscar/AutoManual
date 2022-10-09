<?php

namespace App\Notifications\Channels;

use AfricasTalking\SDK\AfricasTalking;
use App\Notifications\Traits\SmsNotification;
use App\Notifications\Traits\SmsRecepient;
use App\Traits\Misc\FormatedTime;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class SmsNotificationChannel{

    use FormatedTime;

    /**
     * Send the given notification.
     *
     * @param  Notifiable|SmsRecepient $notifiable
     * @param  Notification|SmsNotification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $gateway = config('notifications.sms_gateway');

        if($gateway == 'africas_talking'){
            $this->viaAfricasTalking(
                $notification->getSmsMessage(),
                $notifiable->getSmsPhoneNumber()
            );
        }else{
            // TODO Notify misconfiguration
            // Use file
            $this->viaFile(
                $notification->getSmsMessage(),
                $notifiable->getSmsPhoneNumber()
            );
        }
    }

    /**
     * Send an sms using africas talking
     * @return bool
     */
    private function viaAfricasTalking($message, $phone){
        try{
            $at = new AfricasTalking(
                config('notifications.africas_talking_username'),
                config('notifications.africas_talking_api_key')
            );

            $sms = $at->sms();

            $result = $sms->send([
                'to' => $phone,
                'message' => $message,
            ]);

            return (isset($result['status']) && strtolower($result['status']) == 'success');
        }catch(Exception $e){
            return false;
        }
    }

    /**
     * Log SMS messages to files
     * @return bool
     */
    private function viaFile($message, $phone){
        try{
            $path = "messages/sms/".$phone;

            // Add time to the message
            $message = "[".
                $this->fullFormatedDate(now()).' '.
                $this->fullFormatedTime(now()).
                "] : \t  ".
                $message;

            if(!Storage::exists($path)){
                Storage::put($path, $message);
            }else{
                // Save to the beginning of the file
                Storage::prepend($path, $message."\n");
            }

            return true;
        }catch(Exception $e){
            return false;
        }
    }
}
