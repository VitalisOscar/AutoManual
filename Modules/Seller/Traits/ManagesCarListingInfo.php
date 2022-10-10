<?php

namespace Modules\Seller\Traits;

use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\Seller\Models\Car;
use Modules\Seller\Models\Seller;

trait ManagesCarListingInfo{

    use ManagesCarImages;

    /**
     * Edit an existing car
     *
     * @param Seller $seller The seller editing the car
     * @param Car $original_car Original car object to edit
     * @param array $data Validated request data
     *
     * @return string|Car
     */
    function editCar($seller, $original_car, $data){
        try{

            // from submitted data
            $car = $this->getCarFromRequest($seller, $original_car, $data);

            // check if the car has been modified
            if($car->is($original_car)){
                return Lang::get('seller::errors.nothing_to_update');
            }

            // Save changes
            return $car->save() ?
                $car : Lang::get('errors.unexpected');

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * List a new car
     *
     * @param Seller $seller The seller adding the car
     * @param array $data Validated request data
     * @param string $status The status of the new car (Might be pending approval or payment)
     *
     * @return string|Car
     */
    function addCar($seller, $data, $status){
        try{
            // Get the car object
            $new_car = new Car([
                'status' => $status
            ]);

            $car = $this->getCarFromRequest($seller, $new_car, $data);

            if(!$car->save()){
                return Lang::get('errors.unexpected');
            }

            // Add images
            $res = $this->uploadMainImage($car, $data['main_image']);
            if(is_string($res) || !$res){
                return $res;
            }

            $res = $this->uploadExtraImages($car, $data['images'] ?? []);
            if(is_string($res) || !$res){
                return $res;
            }

            return $car;

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Get a car being edited, or added
     *
     * @param Seller $seller The seller adding or editing the car
     * @param Car $car The car object to add values from request
     * @param array $data Validated request data
     *
     * @return null|Car
     */
    private function getCarFromRequest($seller, $car, $data){
        // set attributes to values passed
        // relations
        $car->category_id = $data['category'];
        $car->body_type_id = $data['body_type'];
        $car->seller_id = $seller->id;
        $car->car_make_id = $data['make'];
        $car->car_model_id = $data['model'];

        // about
        $car->title = $data['title'];
        $car->description = $data['description'];

        // car location
        $car->location = [
            'town' => $data['location']['town'],
            'area' => $data['location']['area'] ?? null,
        ];

        // overview
        $car->mileage = $data['mileage'];
        $car->transmission = $data['transmission'];
        $car->fuel = $data['fuel'];
        $car->engine = $data['engine'];
        $car->color = $data['color'];
        $car->drive_type = $data['drive_type'];
        $car->year = $data['year'];

        // features
        $features = [];

        // only add white listed features
        foreach($data['features'] as $feature){
            if(in_array($feature, Car::FEATURES)) array_push($features, $feature);
        }

        $car->features = $features;

        // pricing
        $car->price = $data['price'];

        return $car;
    }

}
