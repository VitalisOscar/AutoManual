<?php

namespace Modules\MarketPlace\Http\Controllers\MarketPlace;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Repository\PublicListingsRepository;
use Modules\Seller\Repository\SellerRepository;

class PublicListingsController extends Controller
{

    public function all(PublicListingsRepository $repository){
        return $this->json->data(
            $repository->getAllCars($this->user())
        );
    }

    public function bySeller(SellerRepository $sellerRepository, PublicListingsRepository $listingsRepository, $sellerSlug){
        // Get the seller
        $seller = $sellerRepository->getSingleSeller($sellerSlug);

        if($seller == null){
            return Lang::get('marketplace::errors.seller_does_not_exist');
        }

        $result = $listingsRepository->getCarsBySeller($seller, $this->user());

        return $this->json->data([
            'seller' => $seller,
            'result' => $result
        ]);
    }

    public function single(PublicListingsRepository $repository, $slug){
        // Get the car
        $car = $repository->getSingleCar($slug, $this->user());

        if($car == null){
            return Lang::get('marketplace::errors.listing_does_not_exist');
        }

        return $this->json->data($car);
    }

}
