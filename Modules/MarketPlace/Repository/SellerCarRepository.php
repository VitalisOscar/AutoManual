<?php

namespace Modules\MarketPlace\Repository;

use App\Helpers\ResultSet;
use Illuminate\Database\Eloquent\Builder;
use Modules\MarketPlace\Models\Car;
use Modules\Seller\Models\Seller;

/**
 * Fetch cars owned by a particular seller
 */
class SellerCarRepository{

    use CommonFilters;

    protected $options = [];

    /**
     * Add a query option
     *
     * @param string $option
     *
     * @return SellerCarRepository
     */
    function addQueryOption($option){
        array_push($this->options, $option);

        return $this;
    }

    /**
     * Add multiple query options
     *
     * @param array $options
     *
     * @return SellerCarRepository
     */
    function addQueryOptions($option){
        $this->options = array_merge($this->options, $option);

        return $this;
    }

    /**
     * @param Builder $query
     */
    protected function applyOptions($query){
        if(in_array('only_trashed', $this->options)){
            $query->onlyTrashed();
        }

        if(in_array('with_trashed', $this->options)){
            $query->withTrashed();
        }
    }

    /**
     * Get car listings owned by a seller
     *
     * @param Seller $seller
     *
     * @return ResultSet
     */
    function getAllCars($seller){
        $query = $seller->cars();

        // Filters
        $request = request();

        // Status
        if($request->filled('status')){
            $status = strtolower($request->get('status'));

            if($status == 'approved'){
                $query->approved();
            }else if($status == 'rejected'){
                $query->rejected();
            }else if($status == 'pending approval'){
                $query->pendingApproval();
            }else if($status == 'delisted'){
                $query->delisted();
            }
        }

        $query->without('seller'); // No need to load seller info

        // Apply common filters and sorting
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
     * Get a single car listing owned by a seller
     *
     * @param Seller $seller
     * @param int $car_id
     *
     * @return Car|null
     */
    function getSingleCar($seller, $car_id){
        $query = $seller->cars()
            ->where(Car::TABLE_NAME.'.id', $car_id)
            ->without(['seller', 'main_image'])
            ->with('images');

        $this->applyOptions($query);

        return $query->first();
    }

}
