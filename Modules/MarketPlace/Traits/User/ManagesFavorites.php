<?php

namespace Modules\MarketPlace\Traits\User;

use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Car;

trait ManagesFavorites{

    /**
     * Add or remove a car from a user's favorites
     *
     * @param User $user
     * @param Car $car
     *
     * @return string|true
     */
    private function toggleFavoriteStatus($user, $car){
        try{

            // Check if added
            if($user->favorites()->where(Car::TABLE_NAME.'.id', $car->id)->first() != null){
                // Remove
                return $this->removeFavorite($user, $car);
            }else{
                // Add
                return $this->addFavorite($user, $car);
            }

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Add to a user's favorites
     *
     * @param User $user
     * @param Car $car
     *
     * @return string|true
     */
    private function addFavorite($user, $car){
        try{
            $user->favorites()->attach($car->id);

            return true;
        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Remove from a user's favorites
     *
     * @param User $user
     * @param Car $car
     *
     * @return string|true
     */
    private function removeFavorite($user, $car){
        try{
            $user->favorites()->detach($car->id);

            return true;
        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

}
