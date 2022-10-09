<?php

namespace Modules\Seller\Http\Middleware;

use App\Helpers\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class NotSeller
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $closure
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();

        if($user->seller == null){
            return $next($request);
        }

        $response = new JsonResponse();
        return $response->error(Lang::get('seller::errors.already_a_seller'));
    }
}
