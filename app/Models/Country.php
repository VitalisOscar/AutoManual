<?php

namespace App\Models;

use App\Traits\Misc\FormatedTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Account\Models\User;

class Country extends Model
{
    use SoftDeletes;
    use FormatedTime;

    const MODEL_NAME = 'Country';

    protected $table = 'app_countries';
    const TABLE_NAME = 'app_countries';

    protected $fillable = [
        'name',
        'code',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $appends = [
        'added'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // Relations
    function users(){
        return $this->hasMany(User::class, 'country_id');
    }


    // Accessors
    function getAddedAttribute(){
        return $this->prettyDate($this->created_at);
    }
}
