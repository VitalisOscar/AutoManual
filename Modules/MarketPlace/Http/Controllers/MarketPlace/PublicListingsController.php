<?php

namespace Modules\MarketPlace\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Repository\PublicListingsRepository;

class PublicListingsController extends Controller
{

    public function all(PublicListingsRepository $repository){
        return $this->json->data(
            $repository->getAllCars()
        );
    }

    public function single(PublicListingsRepository $repository, $slug){
        // Get the car
        $car = $repository->getSingleCar($slug);

        if($car == null){
            return Lang::get('marketplace::errors.listing_does_not_exist');
        }

        return $this->json->data($car);
    }

}
