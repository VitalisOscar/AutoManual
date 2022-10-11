<?php

namespace Modules\MarketPlace\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\CarUpdatedEvent;
use Modules\MarketPlace\Repository\SellerCarRepository;
use Modules\MarketPlace\Traits\ManagesCarListingInfo;

class EditCarController extends Controller
{

    use Validator, ManagesCarListingInfo;

    public function index(SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->getSingleCar($seller, $car_id);

        if($car == null){
            return Lang::get('marketplace::errors.car_does_not_exist');
        }


        // Validate the request
        $validator = $this->getValidator();

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }

        // Edit the car
        DB::beginTransaction();

        $car = $this->editCar(
            $seller,
            $car,
            $validator->validated()
        );

        if(is_string($car)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($car);
        }

        // Car was listed
        CarUpdatedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.listing_updated'));
    }
}
