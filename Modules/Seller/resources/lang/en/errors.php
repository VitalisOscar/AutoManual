<?php

return [
    // Validation errors
    'name_required' => 'Provide your seller profile name',
    'name_invalid' => 'The provided name is invalid',
    'type_required' => 'Select the type of seller profile you want to create',
    'type_invalid' => 'The profile type selected does not exist',
    'logo_required' => 'You need to select a logo associated to your company or dealership',
    'logo_invalid' => 'The selected logo is invalid. Supported types are png, jpeg and jpg',
    'logo_too_big' => 'The selected logo is too big. Supported file size is upto :max kb. Please compress and upload again',
    'address_required' => 'Provide a physical address where your business can be found',
    'address_invalid' => 'Provide a valid address',
    'town_required' => 'Provide a town name where you are located',
    'town_invalid' => 'Provide a valid town',

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

    'car_does_not_exist' => 'The car listing does not exist, or action is not allowed',
    'nothing_to_update' => 'No changes have been made. Nothing to update',
];
