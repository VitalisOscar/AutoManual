<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    const MODEL_NAME = "Body Type";

    const TABLE_NAME = "app_car_models";
    protected $table = "app_car_models";

    protected $fillable = [
        'name', 'car_make_id', 'slug'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function cars(){ return $this->hasMany(Car::class, 'car_model_id'); }

    function make(){ return $this->belongsTo(CarMake::class, 'car_make_id'); }
}
