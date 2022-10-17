<?php

namespace Modules\MarketPlace\Traits;

use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Models\Car;

trait CarListingDeletion{

    /**
     * Delete a car listing temporarily
     *
     * @param Car $car
     *
     * @return string|Car
     */
    private function trashListing($car){
        try{
            return $car->delete() ?
                $car : Lang::get('errors.unexpected');

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Restore a temporarily deleted listing
     *
     * @param Car $car
     *
     * @return string|Car
     */
    private function restoreListing($car){
        try{
            return $car->restore() ?
                $car : Lang::get('errors.unexpected');

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Delete a car listing permanently
     *
     * @param Car $car
     *
     * @return string|Car
     */
    private function deleteListing($car){
        try{
            return $car->forceDelete() ?
                $car : Lang::get('errors.unexpected');

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

}
