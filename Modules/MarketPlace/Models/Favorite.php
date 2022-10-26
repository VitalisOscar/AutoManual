<?php

namespace Modules\MarketPlace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    const MODEL_NAME = "Favorite";

    const TABLE_NAME = "market_place_favorites";
    protected $table = "market_place_favorites";

    protected $fillable = [
        'user_id',
        'car_id'
    ];

}
