<?php

namespace Modules\Account\Models;

use App\Models\Country;
use App\Notifications\Traits\SmsRecepient;
use App\Traits\Contracts\IsProfile;
use App\Traits\Misc\FormatedTime;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\MarketPlace\Models\Alert;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Models\Favorite;
use Modules\Seller\Models\Seller;

class User extends AuthUser
{
    use Notifiable, HasApiTokens;
    use IsProfile, SmsRecepient;
    use FormatedTime;

    const MODEL_NAME = "User";

    const TABLE_NAME = "accounts_users";
    protected $table = "accounts_users";

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'country_id',
        'password'
    ];

    protected $with = ['country'];

    protected $appends = [
        'registered_on',
        'phone_verified',
        'phone_verified_on',
        'email_verified',
        'email_verified_on',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
        'email_verified_at', 'phone_verified_at',
        'country_id', 'password'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];


    // Relations
    function country(){ return $this->belongsTo(Country::class, 'country_id'); }

    function seller(){ return $this->hasOne(Seller::class, 'user_id'); }

    function favorites(){ return $this->belongsToMany(Car::class, Favorite::TABLE_NAME); }

    function alerts(){ return $this->hasMany(Alert::class, 'user_id'); }


    // Scopes
    function scopePhoneVerified($q){
        $q->whereNotNull('phone_verified_at');
    }

    function scopeEmailVerified($q){
        $q->whereNotNull('email_verified_at');
    }

    function scopeFullyVerified($q){
        $q->phoneVerified()->emailVerified();
    }


    // Accessors
    function getRegisteredOnAttribute(){
        return $this->prettyDate($this->created_at);
    }

    function getPhoneVerifiedAttribute(){
        return $this->hasPhoneVerified();
    }

    function getPhoneVerifiedOnAttribute(){
        return $this->hasPhoneVerified() ?
            $this->prettyDate($this->phone_verified_at) : 'Not Verified';
    }

    function getEmailVerifiedAttribute(){
        return $this->hasEmailVerified();
    }

    function getEmailVerifiedOnAttribute(){
        return $this->hasEmailVerified() ?
            $this->prettyDate($this->email_verified_at) : 'Not Verified';
    }


    // helpers
    /**
     * Get a user's authentication token
     * @return string
     */
    function getAuthToken(){
        $token_name = request()->userAgent().' '.request()->ip();

        // Get other token if existing, or create new one
        $token = $this->currentAccessToken() ?? $this->createToken($token_name);

        // $token = $this->createToken($token_name);

        return $token->plainTextToken;
    }

    function hasPhoneVerified(){
        return isset($this->phone_verified_at);
    }

    function hasEmailVerified(){
        return isset($this->email_verified_at);
    }

    function isFullyVerified(){
        return $this->hasEmailVerified() && $this->hasPhoneVerified();
    }

    function markPhoneVerified(){
        $this->phone_verified_at = now();
        return $this->save();
    }

    function markEmailVerified(){
        $this->email_verified_at = now();
        return $this->save();
    }

    function isSeller(){
        return $this->seller == null;
    }


    // Abstract methods
    // IsProfile
    function getProfileType(){
        return self::MODEL_NAME;
    }

}
