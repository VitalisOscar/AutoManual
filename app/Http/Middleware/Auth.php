<?php

namespace App\Http\Middleware;

use App\Helpers\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Models\User;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $auth_type)
    {
        // Application handles all web and app authentication via sanctum
        // Get the sanctum user
        $user = auth('sanctum')->user();

        $response = new JsonResponse();

        if(!$user){
            // User isn't signed in
            return $response->error(Lang::get('errors.not_signed_in'));
        }

        // Filter by auth type
        $auth_type = strtolower($auth_type);
        $class = get_class($user);

        if($auth_type == 'user'){
            // Check if user is user
            if($class == User::class){
                return $next($request);
            }

            return $response->error(Lang::get('errors.not_signed_in'));
        }

        // if($auth_type == 'admin'){
        //     // Check if user is admin
        //     if($class == Adimin::class){
        //         return $next($request);
        //     }

        //     return $response->error(Lang::get('errors.not_signed_in'));
        // }

        return $response->error(Lang::get('errors.not_signed_in'));
    }
}
