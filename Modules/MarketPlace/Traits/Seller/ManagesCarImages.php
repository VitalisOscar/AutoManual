<?php

namespace Modules\MarketPlace\Traits\Seller;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Models\CarImage;

trait ManagesCarImages{

    /**
     * Upload the main image of a listing, when adding the listing
     *
     * @param Car $car
     * @param UploadedFile $image_file Request data containing the image under main_image key
     *
     * @return true|string
     */
    private function uploadMainImage($car, $image_file){
        try{

            $image = $car->images()->create([
                'is_main' => true,
                'path' => $image_file->store($this->getUploadDir(), 'public')
            ]);

            if($image->id){
                return true;
            }

            return Lang::get('marketplace::errors.unable_to_upload_images');
        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Upload additional images of a listing, when adding the listing
     *
     * @param Car $car
     * @param UploadedFile[] $image_files Request data containing the image under images key
     *
     * @return true|string
     */
    private function uploadExtraImages($car, $image_files){
        try{
            foreach($image_files as $image){
                $img = $car->images()->create([
                    'is_main' => false,
                    'path' => $image->store($this->getUploadDir(), 'public')
                ]);

                if(!$img->id){
                    return Lang::get('marketplace::errors.unable_to_upload_images');
                }
            }

            return true;

        }catch(Exception $e){
            return Lang::get('errors.server');
        }
    }

    /**
     * Add more images to a car
     *
     * @param Car $car
     * @param UploadedFile[] $images Uploaded images to add
     *
     * @return string|true
     */
    private function addImages($car, $images){

        try{
            // check if maximum number of images will be exceeded
            $current_images = $car->images_count;
            $new_images = $current_images + count($images);
            $max = CarImage::MAX_IMAGE_COUNT;

            if($new_images > $max){
                return Lang::get('marketplace::errors.max_images_exceeded', [
                    'max' => $max,
                    'remaining' => $max - $current_images
                ]);

            }

            $upload_dir = $this->getUploadDir();

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
    private function removeImages($car, $image_ids){

        try{

            // Get the current images
            $images_to_delete = $car->images()->whereIn('id', $image_ids)->get();

            // Ensure we do not remove current main image
            foreach($images_to_delete as $image){
                if($image->is_main){
                    return Lang::get('marketplace::errors.cannot_delete_main_image');
                }
            }

            foreach($images_to_delete as $image){
                if($image->delete()){
                    // delete file from disk
                    Storage::delete(storage_path($image->path));
                }else{
                    return Lang::get('marketplace::errors.images_not_deleted');
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
    private function setMainImage($car, $image_id){

        try{

            // check if the image is already added to car
            $new_main_image = $car->images()->whereId($image_id)->first();

            if($new_main_image == null){
                return Lang::get('marketplace::errors.image_does_not_exist');
            }

            // check if it is already main
            if($new_main_image->is_main){
                return Lang::get('marketplace::errors.image_is_already_main');
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

    /**
     * Get the upload dir, in format upload_dir/yyyy/mm/dd
     * @return string
     */
    private function getUploadDir(){
        return CarImage::UPLOAD_DIR.'/'.str_replace('-', '/', today()->format('Y-m-d'));
    }

}
