<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountriesDataController extends Controller
{

    public function getCountries(){
        return $this->json->data(
            Country::all()
        );
    }

}
