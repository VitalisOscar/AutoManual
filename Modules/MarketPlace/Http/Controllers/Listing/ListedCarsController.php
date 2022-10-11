<?php

namespace Modules\MarketPlace\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Repository\SellerCarRepository;

class ListedCarsController extends Controller
{

    public function all(SellerCarRepository $repository){
        return $this->json->data(
            $repository->getAllCars(
                $this->seller()
            )
        );
    }

    public function single(SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->getSingleCar($seller, $car_id);

        if($car == null){
            return Lang::get('marketplace::errors.car_does_not_exist');
        }

        return $this->json->data($car);
    }

}
