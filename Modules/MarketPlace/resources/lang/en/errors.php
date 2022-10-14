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

    // Other
    'already_a_seller' => 'You already have a seller profile associated with your account',
    'not_a_seller' => 'You do not have a seller profile associated with your account',

    // Seller listing errors
    'car_does_not_exist' => 'The car listing does not exist, or action is not allowed',
    'nothing_to_update' => 'No changes have been made. Nothing to update',

    // Marketplace erros
    'listing_does_not_exist' => 'The car listing does not exist or has been deleted',
    'seller_does_not_exist' => 'The seller page does not exist',
];
