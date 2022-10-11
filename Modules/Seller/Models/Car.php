<?php

namespace Modules\Seller\Models;

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use App\Traits\Misc\FormatedTime;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use FormatedTime;

    const MODEL_NAME = "Car";

    const TABLE_NAME = "sellers_cars";
    protected $table = "sellers_cars";

    // Supported seller status
    const STATUS_PENDING_APPROVAL = "Pending Approval";
    const STATUS_APPROVED = "Approved";
    const STATUS_REJECTED = "Rejected";
    const STATUS_DELISTED = "Delisted";

    // Enums
    const TRANSMISSIONS = ['Automatic', 'Manual', 'Semi-Automatic'];
    const FUEL_TYPES = ['Petrol', 'Diesel', 'Electric', 'Hybrid'];
    const DRIVE_TYPES = [
        'AWD' => 'All-Wheel-Drive',
        'FWD' => 'Front Wheel Drive',
        'RWD' => 'Rear Wheel Drive',
        '4WD' => '4 Wheel Drive'
    ];

    const FEATURES = [];

    protected $fillable = [
        'title',
        'price',
        'year',
        'mileage',
        'fuel',
        'transmission',
        'color',
        'engine',
        'drive_type',
        'location',
        'description',
        'seller_id',
        'category_id',
        'body_type_id',
        'car_make_id',
        'car_model_id',
        'features',
        'status'
    ];

    protected $with = ['seller', 'category', 'body_type', 'make', 'model', 'main_image'];
    protected $withCount = ['images'];

    protected $appends = [
        'slug',
        'added_on',
        'total_images'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
        'category_id', 'body_type_id',
        'car_make_id', 'car_model_id',
        'seller_id', 'images_count'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'features' => 'array',
        'location' => 'array',
    ];


    // Relations
    function seller(){ return $this->belongsTo(Seller::class, 'seller_id'); }

    function category(){ return $this->belongsTo(Category::class, 'category_id'); }

    function make(){ return $this->belongsTo(CarMake::class, 'car_make_id'); }

    function model(){ return $this->belongsTo(CarModel::class, 'car_model_id'); }

    function body_type(){ return $this->belongsTo(BodyType::class, 'body_type_id'); }

    function images(){ return $this->hasMany(CarImage::class, 'car_id'); }

    function main_image(){ return $this->hasOne(CarImage::class, 'car_id')->main(); }


    // Scopes
    function scopePendingApproval($q){
        $q->whereStatus(self::STATUS_PENDING_APPROVAL);
    }

    function scopeApproved($q){
        $q->whereStatus(self::STATUS_APPROVED);
    }

    function scopeRejected($q){
        $q->whereStatus(self::STATUS_REJECTED);
    }

    function scopeDelisted($q){
        $q->whereStatus(self::STATUS_DELISTED);
    }

    function scopePublic($q){
        // Can be seen by public
        $q->approved()
            ->whereHas('seller', function($seller){
                $seller->listingsCanBePublic();
            });
    }


    // helpers
    function isApproved(){ return $this->status == self::STATUS_APPROVED; }

    function isPending(){ return $this->status == self::STATUS_PENDING_APPROVAL; }

    function isRejected(){ return $this->status == self::STATUS_REJECTED; }

    function isDelisted(){ return $this->status == self::STATUS_DELISTED; }


    // Accessors
    function getSlugAttribute(){
        return \Illuminate\Support\Str::slug($this->title.' '.$this->id);
    }

    function getAddedOnAttribute(){
        return $this->prettyDate($this->created_at);
    }

    function getTotalImagesAttribute(){
        return $this->images_count;
    }

    function getEngineAttribute($val){
        return number_format($val).' cc';
    }

    function getMileageAttribute($val){
        return number_format($val).' Km';
    }

    function getPriceAttribute($val){
        return number_format($val);
    }

    function getDriveTypeAttribute($val){
        return self::DRIVE_TYPES[$val] ?? $val;
    }

}
