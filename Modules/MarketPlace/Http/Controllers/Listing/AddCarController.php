<?php

namespace Modules\MarketPlace\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\CarListedEvent;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Traits\Seller\ManagesCarListingInfo;

class AddCarController extends Controller
{

    use Validator, ManagesCarListingInfo;

    public function index(){
        // Validate the request
        $validator = $this->getValidator();

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }

        // List the car
        DB::beginTransaction();

        $car = $this->addCar(
            $this->seller(),
            $validator->validated(),
            Car::STATUS_PENDING_APPROVAL
        );

        if(is_string($car)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($car);
        }


        // Update slug with id
        $car->slug .= '-'.$car->id;

        if(!$car->save()){
            DB::rollBack();
            return $this->json->error(Lang::get('errors.unexpected'));
        }


        // Car was listed
        CarListedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.listing_created'));
    }
}
