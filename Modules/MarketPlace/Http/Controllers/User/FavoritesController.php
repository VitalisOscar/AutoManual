<?php

namespace Modules\MarketPlace\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Repository\PublicListingsRepository;
use Modules\MarketPlace\Traits\User\ManagesFavorites;

class FavoritesController extends Controller
{
    use ManagesFavorites;

    public function getAll(PublicListingsRepository $repository){
        return $this->json->data(
            $repository->getUserFavorites($this->user())
        );
    }

    public function addOrRemove(PublicListingsRepository $repository, $car_slug){
        // Get the car
        $car = $repository->getSingleCar($car_slug);

        if($car == null){
            return Lang::get('marketplace::errors.listing_does_not_exist');
        }


        DB::beginTransaction();
        $result = $this->toggleFavoriteStatus(
            $this->user(),
            $car
        );

        if(is_string($result)){
            DB::rollBack();
            return $this->json->error($result);
        }

        DB::commit();
        return $this->json->success(Lang::get('marketplace::success.favorite_status_updated'));
    }

}
