<?php

namespace Modules\Seller\Traits;

use Exception;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Models\User;
use Modules\Seller\Models\ProfileType;
use Modules\Seller\Models\Seller;

trait CreatesProfiles{

    /**
     * Create a new seller profile associated to a particular user
     *
     * @param User $user
     * @param ProfileType $profile_type
     * @param array $data
     *
     * @return Seller|string
     */
    function createSellerProfile($user, $profile_type, $data){
        try{
            $seller = $profile_type->sellers()->create([
                'name' => $data['name'] ?? null,
                'logo' => $data['logo'] ? (
                    $data['logo']->store(Seller::LOGO_STORAGE_DIR, 'public')
                ) : null,
                'user_id' => $user->id,
                'status' => Seller::STATUS_ACTIVE,
                'location' => $data['location'],
            ]);

            if(!$seller->id){
                return Lang::get('errors.unexpected');
            }

            return $seller;
        }catch(Exception $e){
            return Lang::get('errors.server').$e->getMessage();
        }
    }

}
