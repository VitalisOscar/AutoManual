<?php

namespace Modules\Account\Notifications;

use App\Notifications\Channels\SmsNotificationChannel;
use App\Notifications\Traits\SmsNotification;
use App\Traits\Contracts\IsProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Traits\UsesVerificationCodes;

class VerifyCodeNotification extends Notification /*implements ShouldQueue*/
{
    // use Queueable;
    use SmsNotification;
    use UsesVerificationCodes;

    /**
     * @var IsProfile The user profile for which the code to be verified is being generated
     */
    private $profile;

    private $code, $validity;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($profile, $codeUsage)
    {
        $this->profile = $profile;

        $this->validity = config('account.verification_code_validity');

        // Generate new or get existing code
        $this->code = $this->getVerificationCode($profile, $codeUsage, $this->validity);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            SmsNotificationChannel::class
        ];
    }

    /**
     * Get the SMS message to send to a recepient
     *
     * @return string
     */
    function getSmsMessage(){
        return Lang::get('account::messages.verification_code_message', [
            'code' => $this->code,
            'validity' => $this->validity
        ]);
    }
}
