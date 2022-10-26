<?php

namespace Modules\MarketPlace\Repository;

use App\Helpers\ResultSet;
use Illuminate\Database\Eloquent\Builder;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Models\Favorite;
use Modules\Seller\Models\Seller;

/**
 * Fetch public car listings
 */
class PublicListingsRepository{

    use CommonFilters;

    /**
     * Get a user's favorite car listings
     *
     * @param User $user
     *
     * @return ResultSet
     */
    function getUserFavorites($user){
        return new ResultSet(
            $user->favorites()->public(), // Can be seen by public
            null,
            function($car){
                $car->is_favorite = true;
            } // Mark each result as favorite - for the benefit of the UI
        );
    }

    /**
     * Get public car listings
     *
     * @param User $user The current user
     *
     * @return ResultSet
     */
    function getAllCars($user = null){
        return $this->fetchAll(
            Car::public(), // Can be seen by public
            $user
        );
    }

    /**
     * Get car listings by a particular seller
     *
     * @param Seller $seller
     * @param User $user The current user
     *
     * @return ResultSet
     */
    function getCarsBySeller($seller, $user = null){
        return $this->fetchAll(
            $seller->cars()->public(), // Can be seen by public
            $user
        );
    }

    /**
     * Add marketplace filters and fetch
     *
     * @param Builder $query
     * @param User $user The current user
     *
     * @return ResultSet
     */
    function fetchAll($query, $user){
        // Left join to favorites table
        // helps check whether user has marked listing as favorite
        // We'll join if user id matches that of user
        if($user != null){
            $query->leftJoin(Favorite::TABLE_NAME, function ($join) use($user) {
                $join->on(Car::TABLE_NAME.'.id', '=', Favorite::TABLE_NAME.'.car_id')
                    ->where(Favorite::TABLE_NAME.'.user_id', $user->id);
            });

            // if id exists, is favorite will be true
            $query->addSelect([
                Favorite::TABLE_NAME.'.id AS is_favorite'
            ]);

        }

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
     * @param string $slug
     * @param User $user The current user
     *
     * @return Car|null
     */
    function getSingleCar($slug, $user = null){
        $query = Car::public() // Public
            ->where(Car::TABLE_NAME.'.slug', $slug)
            ->without(['main_image'])
            ->with('images');

        // Left join to favorites table
        // helps check whether user has marked listing as favorite
        // We'll join if user id matches that of user
        if($user != null){
            $query->leftJoin(Favorite::TABLE_NAME, function ($join) use($user) {
                $join->on(Car::TABLE_NAME.'.id', '=', Favorite::TABLE_NAME.'.car_id')
                    ->where(Favorite::TABLE_NAME.'.user_id', $user->id);
            });

            // if id exists, is favorite will be true
            $query->addSelect([
                Favorite::TABLE_NAME.'.id AS is_favorite'
            ]);

        }

        return $query->first();
    }

}
