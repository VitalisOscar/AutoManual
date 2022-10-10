<?php

namespace Modules\Seller\Http\Controllers\Cars;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\Seller\Events\Cars\CarListedEvent;
use Modules\Seller\Models\Car;
use Modules\Seller\Traits\ManagesCarListingInfo;

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

        // Car was listed
        CarListedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('seller::success.listing_created'));
    }
}
