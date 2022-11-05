<?php

namespace Modules\MarketPlace\Models;

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Models\User;

class Alert extends Model
{
    const MODEL_NAME = "Alert";

    const TABLE_NAME = "market_place_alerts";
    protected $table = "market_place_alerts";

    protected $fillable = [
        'maximum_price',
        'maximum_mileage',
        'transmission',
        'town',
        'category_id',
        'body_type_id',
        'car_make_id',
        'car_model_id',
        'user_id'
    ];

    protected $with = [
        'category', 'body_type', 'make', 'model'
    ];

    protected $appends = ['data'];

    protected $hidden = [
        'category', 'body_type', 'make', 'model', 'user_id',
        'category_id', 'body_type_id', 'car_make_id', 'car_model_id',
        'maximum_price', 'maximum_mileage', 'transmission', 'town',
    ];

    // Relations
    function user(){ return $this->belongsTo(User::class, 'user_id'); }

    function category(){ return $this->belongsTo(Category::class, 'category_id'); }

    function make(){ return $this->belongsTo(CarMake::class, 'make_id'); }

    function model(){ return $this->belongsTo(CarModel::class, 'car_model_id'); }

    function body_type(){ return $this->belongsTo(BodyType::class, 'body_type_id'); }

    // Scopes
    // Check whether a car matches the alert
    /**
     * @param Car $car
     */
    function scopeMatchesCar($q, $car){
        $q->where(function($query) use($car){
                $query->where('maximum_mileage', null)
                    ->orWhere('maximum_mileage', '>=', $car->getOriginal('mileage'));
            }) // Mileage condition should be null or the car should have
            // less mileage than desired maximum value

            ->where(function($query) use($car){
                $query->where('maximum_price', null)
                    ->orWhere('maximum_price', '>=', $car->getOriginal('price'));
            }) // Price condition should be null or the car should have
            // cost less than desired maximum value


            // Other fixed conditions should be null or same as the car's provided values
            ->where(function($query) use($car){
                $query->where('town', null)
                    ->orWhere('town', $car->location['town']);
            });

        $attributes = [
            'category_id', 'body_type_id', 'make_id', 'car_model_id', 'transmission'
        ];

        foreach($attributes as $attribute){
            $q->where(function($query) use($car, $attribute){
                    $query->where($attribute, null)
                        ->orWhere($attribute, $car->getOriginal($attribute));
                });
        }
    }




    function getDataAttribute(){
        $data = [];

        if($this->category) $data['category'] = $this->category;
        if($this->body_type) $data['body_type'] = $this->body_type;
        if($this->model) $data['model'] = $this->model;
        if($this->make) $data['make'] = $this->make;

        if($this->maximum_price) $data['maximum_price'] = $this->maximum_price;
        if($this->maximum_mileage) $data['maximum_mileage'] = $this->maximum_mileage;
        if($this->transmission) $data['transmission'] = $this->transmission;
        if($this->town) $data['town'] = $this->town;

        return $data;
    }
}
