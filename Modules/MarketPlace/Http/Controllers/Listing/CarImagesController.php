<?php

namespace Modules\MarketPlace\Http\Controllers\Listing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\CarUpdatedEvent;
use Modules\MarketPlace\Models\CarImage;
use Modules\MarketPlace\Repository\SellerCarRepository;
use Modules\MarketPlace\Traits\Seller\ManagesCarImages;

class CarImagesController extends Controller
{

    use ManagesCarImages;

    public function add(Request $request, SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->getSingleCar($seller, $car_id);

        if($car == null){
            return Lang::get('marketplace::errors.car_does_not_exist');
        }


        // Validate the request
        $validator = validator($request->file(), [
            'images' => 'required|array',
            'images.*' => 'image|max:'.CarImage::MAX_IMAGE_SIZE.'kb|mime_types:image/png,image/jpeg,image/jpg'
        ], [
            'images.required' => Lang::get('marketplace::errors.upload_some_images'),
            'images.array' => Lang::get('marketplace::errors.upload_some_images'),
            'images.*.image' => Lang::get('marketplace::errors.only_images_are_supported'),
            'images.*.max' => Lang::get('marketplace::errors.max_image_size_exceeded', ['max' => CarImage::MAX_IMAGE_SIZE]),
            'images.*.mime_types' => Lang::get('marketplace::errors.only_images_are_supported'),
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }

        // Add the images
        DB::beginTransaction();

        $result = $this->addImages($car, $request->file('images'));

        if(is_string($result)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($result);
        }

        // Car was updated
        CarUpdatedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.images_uploaded'));
    }

    public function updateMain(Request $request, SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->getSingleCar($seller, $car_id);

        if($car == null){
            return Lang::get('marketplace::errors.car_does_not_exist');
        }


        // Validate the request
        $validator = validator($request->post(), [
            'image_id' => 'required'
        ], [
            'image_id.required' => Lang::get('marketplace::errors.select_image_to_set_as_main'),
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }

        // Update main image
        DB::beginTransaction();

        $result = $this->setMainImage($car, $request->post('image_id'));

        if(is_string($result)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($result);
        }

        // Car was updated
        CarUpdatedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.main_image_updated'));
    }

    public function delete(Request $request, SellerCarRepository $repository, $car_id){
        $seller = $this->seller();

        // Get the car
        $car = $repository->getSingleCar($seller, $car_id);

        if($car == null){
            return Lang::get('marketplace::errors.car_does_not_exist');
        }


        // Validate the request
        $validator = validator($request->post(), [
            'image_ids' => 'required|array',
        ], [
            'image_ids.required' => Lang::get('marketplace::errors.select_images_to_delete'),
            'image_ids.array' => Lang::get('marketplace::errors.select_images_to_delete'),
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }

        // Delete the images
        DB::beginTransaction();

        $result = $this->removeImages($car, $request->post('image_ids'));

        if(is_string($result)){
            // Error did occur
            DB::rollBack();
            return $this->json->error($result);
        }

        // Car was updated
        CarUpdatedEvent::dispatch($car);
        DB::commit();

        return $this->json->success(Lang::get('marketplace::success.images_removed'));
    }
}
