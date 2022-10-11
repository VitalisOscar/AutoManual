<?php

namespace Modules\Seller\Repository;

use App\Helpers\ResultSet;
use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Modules\Seller\Models\Car;
use Modules\Seller\Models\Seller;

/**
 * Fetch cars owned by a particular seller
 */
class SellerCarRepository{

    /**
     * Get car listings owned by a seller
     *
     * @param Seller $seller
     *
     * @return ResultSet
     */
    function getAllCars($seller){
        $cars = $seller->cars();

        // Filters
        $request = request();

        // Status
        if($request->filled('status')){
            $status = strtolower($request->get('status'));

            if($status == 'approved'){
                $cars->approved();
            }else if($status == 'rejected'){
                $cars->rejected();
            }else if($status == 'pending approval'){
                $cars->pendingApproval();
            }else if($status == 'delisted'){
                $cars->delisted();
            }
        }

        // Category
        if($request->filled('category')){
            $cars->whereHas('category', function($category) use($request){
                $category->where(Category::TABLE_NAME.'.id', $request->get('category'));
            });
        }

        // Body type
        if($request->filled('body_type')){
            $cars->whereHas('body_type', function($body_type) use($request){
                $body_type->where(BodyType::TABLE_NAME.'.id', $request->get('body_type'));
            });
        }

        // Model
        // If one filters by model, the make is already covered, no need
        // for an additional make filter hence the else{} part
        if($request->filled('model')){
            $cars->whereHas('model', function($model) use($request){
                $model->where(CarModel::TABLE_NAME.'.id', $request->get('model'));
            });
        }else{
            // Make
            if($request->filled('make')){
                $cars->whereHas('make', function($make) use($request){
                    $make->where(CarMake::TABLE_NAME.'.id', $request->get('make'));
                });
            }

        }

        // Ordering
        if($request->filled('sort')){
            $sort = strtolower($request->get('sort'));

            if($sort == 'oldest'){
                $cars->oldest();
            }else if($sort == 'atoz'){
                $cars->orderBy('title', 'ASC');
            }else if($sort == 'ztoa'){
                $cars->orderBy('title', 'DESC');
            }else{
                $cars->latest();
            }
        }else{
            $cars->latest();
        }

        // No need to fetch seller info
        $cars->without('seller');

        return new ResultSet($cars);
    }

    /**
     * Get a single car listing owned by a seller
     *
     * @param Seller $seller
     * @param int $car_id
     *
     * @return Car|null
     */
    function getSingleCar($seller, $car_id){
        return $seller->cars()
            ->where(Car::TABLE_NAME.'.id', $car_id)
            ->without(['seller', 'main_image'])
            ->with('images')
            ->first();
    }

}
