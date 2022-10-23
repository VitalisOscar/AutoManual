<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarMake extends Model
{
    const MODEL_NAME = "Make";

    const TABLE_NAME = "app_car_makes";
    protected $table = "app_car_makes";

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

    function cars(){ return $this->hasMany(Car::class, 'car_make_id'); }

    function models(){ return $this->hasMany(CarModel::class, 'car_make_id'); }
}
