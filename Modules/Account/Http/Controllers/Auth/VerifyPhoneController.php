<?php

namespace Modules\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Events\Auth\PhoneVerifiedEvent;
use Modules\Account\Notifications\VerifyCodeNotification;
use Modules\Account\Traits\UsesVerificationCodes;

class VerifyPhoneController extends Controller
{

    use UsesVerificationCodes;

    private const PHONE_VERIFICATION = 'phone_verification';

    public function requestCode(){
        // Check if the phone is already verified
        $user = $this->user();

        if($user->hasPhoneVerified()){
            return Lang::get('account::errors.phone_is_already_verified');
        }

        try{
            $notification = new VerifyCodeNotification($user, self::PHONE_VERIFICATION);


            // Send the notification
            $user->notify($notification);


            return $this->json->success(Lang::get('account::success.verification_code_sent_to_phone', [
                'phone' => $user->phone
            ]));

        }catch(Exception $e){
            return $this->json->error(Lang::get('errors.server'));
        }

    }

    public function verify(Request $request){

        // Check if the phone is already verified
        $user = $this->user();

        if($user->hasPhoneVerified()){
            return Lang::get('account::errors.phone_is_already_verified');
        }

        // Validate
        $validator = validator($request->post(), [
            'code' => 'required|numeric'
        ],[
            'code.required' => Lang::get('account::errors.verification_code_required'),
            'code.numeric' => Lang::get('account::errors.verification_code_invalid'),
        ]);

        if($validator->fails()) {
            return $this->json->errors($validator->errors());
        }


        // Verify
        try{
            $code = $request->post('code');

            if(!$this->checkVerificationCode($code, $user, self::PHONE_VERIFICATION)){
                return Lang::get('account::errors.invalid_or_expired_code');
            }

            // Done. Save the change
            if(!$user->markPhoneVerified()){
                return $this->json->error(Lang::get('errors.unexpected'));
            }


            PhoneVerifiedEvent::dispatch($user);

            return $this->json->success(Lang::get('account::success.phone_verified_successfully'));

        }catch(Exception $e){
            return $this->json->error(Lang::get('errors.server'));
        }

    }
}
