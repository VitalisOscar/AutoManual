<?php

namespace Modules\Seller\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Models\User;

class ProfileType extends Model
{
    const MODEL_NAME = "Seller Type";

    const TABLE_NAME = "sellers_profile_types";
    protected $table = "sellers_profile_types";

    const PERSONAL = 'Personal';
    const DEALERSHIP = 'Dealership';
    const COMPANY = 'Auto Company';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // Relations
    function sellers(){ return $this->hasMany(Seller::class, 'profile_type_id'); }


    // helpers
    function forPersonal(){
        return $this->name == self::PERSONAL;
    }
}
