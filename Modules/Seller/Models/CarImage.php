<?php

namespace Modules\Seller\Models;

use App\Traits\Misc\FormatedTime;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use FormatedTime;

    const MODEL_NAME = "Car Image";

    const TABLE_NAME = "sellers_car_images";
    protected $table = "sellers_car_images";


    const MAX_IMAGE_COUNT = 12;
    const UPLOAD_DIR = 'cars/images';


    protected $fillable = [
        'car_id',
        'path',
        'is_main'
    ];

    protected $appends = [
        'url', 'uploaded_on'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
        'car_id', 'path'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_main' => 'boolean',
    ];


    // Relations
    function car(){ return $this->belongsTo(Car::class, 'car_id'); }

    // Accessors
    function getUrlAttribute(){
        return asset('storage/' . $this->path);
    }

    function getUploadedOnAttribute(){
        return $this->prettyDate($this->created_at);
    }
}
