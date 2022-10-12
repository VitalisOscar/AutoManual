<?php

namespace Modules\MarketPlace\Repository;

use App\Helpers\ResultSet;
use Illuminate\Database\Eloquent\Builder;
use Modules\MarketPlace\Models\Car;
use Modules\Seller\Models\Seller;

/**
 * Fetch public car listings
 */
class PublicListingsRepository{

    use CommonFilters;

    /**
     * Get public car listings
     *
     * @return ResultSet
     */
    function getAllCars(){
        return $this->fetchAll(
            Car::public() // Can be seen by public
        );
    }

    /**
     * Get car listings by a particular seller
     *
     * @param Seller $seller
     *
     * @return ResultSet
     */
    function getCarsBySeller($seller){
        return $this->fetchAll(
            $seller->cars() // By particular seller
                ->public() // Can be seen by public
        );
    }

    /**
     * Add marketplace filters and fetch
     *
     * @param Builder $query
     *
     * @return ResultSet
     */
    function fetchAll($query){
        return new ResultSet(
            $this->sort( // Sort
                $this->filterBodyType( // Filter by body type as needed
                    $this->filterCategory( // Filter by category as needed
                        $this->filterModel($query) // Filter by model or make as needed
                    )
                )
            )
        );
    }

    /**
     * Get a single public car listing
     *
     * @param int $car_id
     *
     * @return Car|null
     */
    function getSingleCar($car_id){
        return Car::public() // Public
            ->where(Car::TABLE_NAME.'.id', $car_id)
            ->without(['main_image'])
            ->with('images')
            ->first();
    }

}
