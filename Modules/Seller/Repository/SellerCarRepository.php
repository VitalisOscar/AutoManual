<?php

namespace Modules\Seller\Repository;

use Modules\Seller\Models\Car;
use Modules\Seller\Models\Seller;

/**
 * Fetch cars owned by a particular seller
 */
class SellerCarRepository{

    /**
     * Get a single car listing owned by a seller
     *
     * @param Seller $seller
     * @param int $car_id
     *
     * @return Car|null
     */
    function getSingleCar($seller, $car_id){
        return $seller->cars()
            ->where(Car::TABLE_NAME.'.id', $car_id)
            ->first();
    }

}
