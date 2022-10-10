<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Account\Models\User;
use Modules\Seller\Models\Seller;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $json;

    function __construct(JsonResponse $json){
        $this->json = $json;
    }

    function view($view, $data = [], $status = 200, array $headers = []){
        return response()->view($view, $data, $status, $headers);
    }

    /**
     * Get the current user
     * @return User
     */
    function user()
    {
        try{
            $user = auth('sanctum')->user();

            if(get_class($user) == User::class){
                return $user;
            }

            return null;
        }catch(Exception $e){
            return null;
        }
    }

    /**
     * Get the current seller profile
     * @return Seller
     */
    function seller(){
        try{
            $user = $this->user();

            if($user != null){
                return $user->seller;
            }

            return null;
        }catch(Exception $e){
            return null;
        }
    }
}
