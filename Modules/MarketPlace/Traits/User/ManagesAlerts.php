<?php

namespace Modules\MarketPlace\Traits\User;

use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Alert;
use Modules\MarketPlace\Repository\UserAlertsRepository;

trait ManagesAlerts{

    /**
     * Create a new user's alert
     *
     * @param User $user
     * @param array $data
     *
     * @return string|Alert
     */
    private function createNewAlert($user, $data){
        try{
            // Check if a similar alert exists
            /** @var UserAlertsRepository */
            $repository = resolve(UserAlertsRepository::class);

            $result = $repository->searchAlert($user, $data);

            // Error occurred
            if(is_string($result)){
                return $result;
            }

            if($result != null){
                // Exists
                return Lang::get('marketplace::errors.alert_already_set');
            }

            // Add
            $alert = $user->alerts()->create($data);

            return $alert->id ? $alert : Lang::get('errors.unexpected');

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Delete an alert
     *
     * @param Alert $alert
     *
     * @return string|true
     */
    private function deleteAlert($alert){
        try{
            $alert->delete();

            return true;
        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

}
