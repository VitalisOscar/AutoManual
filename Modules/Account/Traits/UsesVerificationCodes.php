<?php

namespace Modules\Account\Traits;

use App\Traits\Contracts\IsProfile;
use Illuminate\Support\Facades\Cache;

trait UsesVerificationCodes{

    /**
     * Generate a new or get a usable verification code
     *
     * @param IsProfile $profile - The user profile for which to generate the verification code
     * @param string $codeUsage - The usage if the verification code e.g otp, phone_verification
     * @param int $expiryMinutes - The minutes which a new code is valid. Will be ignored if code was already generated
     *
     * @return string
     */
    function getVerificationCode($profile, $codeUsage, $expiryMinutes = 0){
        // Key to store the code in cache with
        $cacheKey = $this->getCodeStorageKey($profile, $codeUsage);

        // Check if a code exists
        $code = Cache::get($cacheKey);

        if($code == null){
            // Generate a new one
            $code = "";

            // Codes shall be 6 numbers long
            for($i = 0; $i < 6; $i++){
                $code .= rand(1, 9);
            }

            Cache::put($cacheKey, $code, now()->addMinutes($expiryMinutes));
        }

        return $code;
    }

    /**
     * Check if the code provided by user matches the valid stored code
     *
     * @param string $providedCode - The code provided by the user
     * @param IsProfile $profile - The user profile verifying the code
     * @param string $codeUsage - The usage of the verification code e.g otp, phone_verification
     *
     * @return bool
     */
    function checkVerificationCode($providedCode, $profile, $codeUsage){
        if($providedCode == null){
            return false;
        }

        // Key to use to extract cache value
        $cacheKey = $this->getCodeStorageKey($profile, $codeUsage);

        $verificationCode = Cache::get($cacheKey);

        return ($verificationCode == $providedCode);
    }

    /**
     * Get final unique storage key for a code
     *
     * @param IsProfile $profile - The user profile for which to generate the verification code
     * @param string $codeUsage - The usage if the verification code e.g otp, phone_verification
     *
     * @return string
     */
    function getCodeStorageKey($profile, $codeUsage){
        // e.g otp:user:122:192.168.34.21
        return $codeUsage.":".$profile->getProfileType().":".$profile->getProfileId().":".request()->ip();
    }

}
