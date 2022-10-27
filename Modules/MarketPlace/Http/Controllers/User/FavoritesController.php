<?php

namespace Modules\MarketPlace\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\FavoriteAddedEvent;
use Modules\MarketPlace\Events\FavoriteRemovedEvent;
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

        $user = $this->user();

        // Handle
        DB::beginTransaction();

        // Check if added
        if($car->savedBy($user)){
            // Remove
            $result = $this->removeFavorite($user, $car);
            $mode = 'remove';
        }else{
            // Add
            $result = $this->addFavorite($user, $car);
            $mode = 'add';
        }

        if(is_string($result)){
            DB::rollBack();
            return $this->json->error($result);
        }

        // Done
        if($mode == 'add'){
            FavoriteAddedEvent::dispatch($user, $car);
        }else{
            FavoriteRemovedEvent::dispatch($user, $car);
        }

        DB::commit();
        return $this->json->success(Lang::get('marketplace::success.favorite_status_updated'));
    }

}
