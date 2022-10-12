<?php

namespace Modules\MarketPlace\Repository;

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;

/**
 * Functions for applying common filters to queries for getting listings
 */
trait CommonFilters{

    function filterBodyType($query){
        if(request()->filled('body_type')){
            return $query->whereHas('body_type', function($body_type){
                $body_type->where(BodyType::TABLE_NAME.'.id', request()->get('body_type'));
            });
        }

        return $query;
    }

    function filterCategory($query){
        if(request()->filled('category')){
            return $query->whereHas('category', function($category){
                $category->where(Category::TABLE_NAME.'.id', request()->get('category'));
            });
        }

        return $query;
    }

    function filterModel($query){
        // If one filters by model, the make is already covered, no need
        // for an additional make filter hence the else{} part
        if(request()->filled('model')){
            return $query->whereHas('model', function($model){
                $model->where(CarModel::TABLE_NAME.'.id', request()->get('model'));
            });
        }else{
            // Make
            if(request()->filled('make')){
                return $query->whereHas('make', function($make){
                    $make->where(CarMake::TABLE_NAME.'.id', request()->get('make'));
                });
            }

        }

        return $query;
    }

    function sort($query){
        if(request()->filled('sort')){
            $sort = strtolower(request()->get('sort'));

            if($sort == 'oldest'){
                $query->oldest(); // Posted a while ago comes first
            }else if($sort == 'atoz'){
                $query->orderBy('title', 'ASC'); // A comes before Z
            }else if($sort == 'ztoa'){
                $query->orderBy('title', 'DESC'); // Z comes before A
            }else{
                $query->latest(); // Default
            }
        }else{
            $query->latest(); // Default
        }

        return $query;
    }

}
