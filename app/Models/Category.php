<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const MODEL_NAME = "Category";

    const TABLE_NAME = "app_categories";
    protected $table = "app_categories";

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function cars(){ return $this->hasMany(Car::class, 'category_id'); }
}
