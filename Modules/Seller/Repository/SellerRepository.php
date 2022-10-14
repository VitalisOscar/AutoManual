<?php

namespace Modules\Seller\Repository;

use Modules\Seller\Models\Seller;

/**
 * Fetch seller info
 */
class SellerRepository{

    /**
     * Get a single seller
     *
     * @param string $slug
     *
     * @return Seller|null
     */
    function getSingleSeller($slug){
        return Seller::public() // Public
            ->where(Seller::TABLE_NAME.'.slug', $slug)
            ->first();
    }

}
