<?php

namespace Modules\Seller\Models;

use App\Notifications\Traits\SmsRecepient;
use App\Traits\Contracts\IsProfile;
use App\Traits\Misc\FormatedTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Car;

class Seller extends Model
{
    use Notifiable;
    use IsProfile, SmsRecepient;
    use FormatedTime;

    const MODEL_NAME = "Seller";

    const TABLE_NAME = "sellers_profiles";
    protected $table = "sellers_profiles";

    // Supported seller status
    const STATUS_ACTIVE = "Active";
    const STATUS_DEACTIVATED = "Deactivated";

    const LOGO_STORAGE_DIR = 'sellers/logos';
    const PLACEHOLDER_LOGO = 'sellers/logos/default.png';

    protected $fillable = [
        'name',
        'profile_type_id',
        'user_id',
        'location',
        'logo',
        'status',
        'slug'
    ];

    protected $with = ['user', 'profile_type'];

    protected $appends = [
        'registered_on',
        'verified',
        'verified_on',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
        'verified_at', 'user_id',
        'profile_type_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'verified_at' => 'datetime',
        'location' => 'array',
    ];


    // Relations
    function user(){ return $this->belongsTo(User::class, 'user_id'); }

    function profile_type(){ return $this->belongsTo(ProfileType::class, 'profile_type_id'); }

    function cars(){ return $this->hasMany(Car::class, 'seller_id'); }


    // Scopes
    function scopeActive($q){
        $q->whereStatus(self::STATUS_ACTIVE);
    }

    function scopeDeactivated($q){
        $q->whereStatus(self::STATUS_DEACTIVATED);
    }

    function scopeVerified($q){
        $q->whereNotNull('verified_at');
    }

    function scopeCanCreateListings($q){
        $q->verified() // Verified by admin
            ->active() // Active status
            ->whereHas('user', function($user){
                $user->fullyVerified();
            }); // User verification done
    }

    function scopeListingsCanBePublic($q){
        // Listings can be shown to public
        $q->active() // Active status
            ->whereHas('user', function($user){
                $user->fullyVerified();
            }); // User verification done
    }


    // Accessors
    function getNameAttribute($val){
        // Private sellers will use their names
        // $val will be null
        return $val ?? $this->user->name;
    }

    function getLogoAttribute($val){
        // We use a placeholder logo for sellers with no logo (Private sellers)
        return asset('storage/' . ($val ?? self::PLACEHOLDER_LOGO));
    }

    function getRegisteredOnAttribute(){
        return $this->prettyDate($this->created_at);
    }

    function getVerifiedAttribute(){
        return $this->isVerified();
    }

    function getVerifiedOnAttribute(){
        return $this->isVerified() ?
            $this->prettyDate($this->verified_at) : 'Not Verified';
    }


    // helpers
    function isActive(){
        return $this->status == self::STATUS_ACTIVE;
    }

    function isDeactivated(){
        return $this->status == self::STATUS_DEACTIVATED;
    }

    function isVerified(){
        return isset($this->verified_at);
    }

    function canCreateListings(){
        return $this->isActive() // Active status
            && $this->isVerified() // Verified by admin
            && $this->user->isFullyVerified(); // User account is verified
    }

    function markVerified(){
        $this->verified_at = now();
        return $this->save();
    }


    // Abstract methods
    // IsProfile
    function getProfileType(){
        return self::MODEL_NAME;
    }

    // SmsRecepient
    function getSmsPhoneNumber(){
        return $this->user->phone;
    }
}
