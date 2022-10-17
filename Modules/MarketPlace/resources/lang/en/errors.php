<?php

return [
    // Validation errors

    // Images
    'max_images_exceeded' => 'A listing can have a maximum of :max images. You can only upload :remaining at the moment',

    'cannot_delete_main_image' => 'You cannot delete the main image. Set another image as main then try again',
    'images_not_deleted' => 'Some selected images were not deleted',

    'image_does_not_exist' => 'The selected image does not belong to the car listing',
    'image_is_already_main' => 'The selected image is already the main image of the car listing',
    'unable_to_upload_images' => 'Unable to upload the selected image files',

    'upload_some_images' => 'Upload at least one image',
    'only_images_are_supported' => 'Only png, jpg and jpeg images are supported',
    'max_image_size_exceeded' => 'The image size exceeds the maximum allowed size of :max',

    'select_images_to_delete' => 'Select at least one image to be deleted',
    'select_image_to_set_as_main' => 'Select an image to set as main image',
    'image_does_not_exist' => 'Selected image does not exist or has been deleted',

    // Seller listing errors
    'car_does_not_exist' => 'The car listing does not exist, or action is not allowed',
    'car_is_not_trashed' => 'The car listing cannot be restored as it has not been deleted',
    'nothing_to_update' => 'No changes have been made. Nothing to update',

    // Marketplace erros
    'listing_does_not_exist' => 'The car listing does not exist or has been deleted',
    'seller_does_not_exist' => 'The seller page does not exist',
];
