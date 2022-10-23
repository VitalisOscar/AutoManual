<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Models\Car;

class BodyType extends Model
{
    const MODEL_NAME = "Body Type";

    const TABLE_NAME = "app_body_types";
    protected $table = "app_body_types";

    protected $fillable = [
        'name', 'slug'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function cars(){ return $this->hasMany(Car::class, 'body_type_id'); }
}
