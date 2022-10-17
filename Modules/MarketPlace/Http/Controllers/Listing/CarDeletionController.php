<?php

namespace Modules\MarketPlace\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\CarDeletedEvent;
use Modules\MarketPlace\Events\CarRestoredEvent;
use Modules\MarketPlace\Repository\SellerCarRepository;
use Modules\MarketPlace\Traits\CarListingDeletion;

class CarDeletionController extends Controller
{

    use CarListingDeletion;

    public function deleteOrTrash(SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->addQueryOption('with_trashed')
            ->getSingleCar($seller, $car_id);

        if($car == null){
            return $this->json->error(Lang::get('marketplace::errors.car_does_not_exist'));
        }


        // Delete the car
        DB::beginTransaction();

        $mode = $car->trashed() ? 'permanent' : 'temporary';

        $result = $mode == 'permanent' ?
            $this->deleteListing($car) : $this->trashListing($car);

        if(is_string($result)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($result);
        }

        // Car was deleted
        CarDeletedEvent::dispatch($car);
        DB::commit();

        if($mode == 'permanent'){
            return $this->json->success(Lang::get('marketplace::success.listing_deleted'));
        }else{
            return $this->json->success(Lang::get('marketplace::success.listing_trashed'));
        }
    }

    public function restoreTrashed(SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->addQueryOption('only_trashed')
            ->getSingleCar($seller, $car_id);

        if($car == null){
            return $this->json->error(Lang::get('marketplace::errors.car_is_not_trashed'));
        }

        // Restore the car
        DB::beginTransaction();

        $result = $this->restoreListing($car);

        if(is_string($result)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($result);
        }

        // Car was restored
        CarRestoredEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.listing_restored'));
    }
}
