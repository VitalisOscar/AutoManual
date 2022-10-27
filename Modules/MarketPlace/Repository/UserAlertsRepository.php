<?php

namespace Modules\MarketPlace\Repository;

use App\Helpers\ResultSet;
use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Alert;

/**
 * Fetch a user's listing alerts
 */
class UserAlertsRepository{

    /**
     * Get a user's alerts
     *
     * @param User $user
     *
     * @return ResultSet
     */
    function getUserAlerts($user){
        return new ResultSet(
            $user->alerts()
        );
    }

    /**
     * Search for an alert based on data
     *
     * @param User $user The current user
     * @param array $data
     *
     * @return Alert|null|string
     */
    function searchAlert($user, $data){
        try{
            $query = $user->alerts();

            foreach($data as $attribute => $value){
                $query->where($attribute, $value);
            }

            return $query->first();
        }catch(Exception $e){
            return Lang::get('errors.server');
        }

    }

}
