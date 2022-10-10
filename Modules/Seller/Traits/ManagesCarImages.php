<?php

namespace Modules\Seller\Traits;

use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Modules\Seller\Models\Car;
use Modules\Seller\Models\CarImage;

trait ManagesCarImages{

    /**
     * Add more images to a car
     *
     * @param Car $car
     * @param UploadedFile[] $images Uploaded images to add
     *
     * @return string|true
     */
    function addImages($car, $images){

        try{
            // check if maximum number of images will be exceeded
            $current_images = $car->images_count;
            $new_images = $current_images + count($images);
            $max = CarImage::MAX_IMAGE_COUNT;

            if($new_images > $max){
                return Lang::get('seller::errors.max_images_exceeded', [
                    'max' => $max,
                    'remaining' => $max - $current_images
                ]);

            }

            $upload_dir = $this->getCarImageUploadDir();

            foreach($images as $image_file){
                $image = $car->images()->create([
                    'is_main' => false,
                    'path' => $image_file->store($upload_dir, 'public'),
                ]);

                if(!$image->id){
                    return Lang::get('errors.unexpected');
                }
            }

            return true;

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Remove images from a car
     *
     * @param Car $car
     * @param array $image_ids Ids of images to remove
     * @return string|true
     */
    function removeImages($car, $image_ids){

        try{

            // delete images being removed that belong to the car
            $car_images = $car->images;

            foreach($car_images as $image){

                // ensure image is not main
                if($image->is_main){
                    return Lang::get('seller::errors.cannot_delete_main_image');
                }

                if(in_array($image_ids, $image->id)){
                    if($image->delete()){
                        // delete file from disk
                        Storage::delete(storage_path($image->path));
                    }else{
                        return Lang::get('seller::errors.images_not_deleted');
                    }
                }else{
                    return Lang::get('seller::errors.images_not_deleted');
                }
            }

            return true;

        }catch(Exception $e){
            return Lang::get('errors.server');
        }

    }

    /**
     * Change the main image of a car
     *
     * @param Car $car
     * @param int $image_id Id of image to set as main
     *
     * @return string|true
     */
    function setMainImage($car, $image_id){

        try{

            // check if the image is already added to car
            $new_main_image = $car->images()->where('id', $image_id);

            if($new_main_image == null){
                return Lang::get('seller::errors.image_does_not_exist');
            }

            // check if it is already main
            if($new_main_image->is_main){
                return Lang::get('seller::errors.image_is_already_main');
            }

            // get the current main image
            $current_main_image = $car->main_image;

            // make changes
            $current_main_image->is_main = false;
            $new_main_image->is_main = true;

            if(!($new_main_image->save() && $current_main_image->save())){
                return Lang::get('errors.unexpected');
            }

            return true;

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

}
