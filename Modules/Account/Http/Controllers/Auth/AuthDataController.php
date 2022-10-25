<?php

namespace Modules\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class AuthDataController extends Controller
{

    public function refreshUser(){
        return $this->json->data($this->user());
    }
}
