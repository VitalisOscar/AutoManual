<?php

namespace Modules\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Events\Auth\UserLoggedInEvent;
use Modules\Account\Models\User;

class LoginController extends Controller
{

    public function index(Request $request){
        // Validate
        $data = $request->post();

        $validator = validator($data, [
            'email' => 'required|email',
            'password' => ['required'],
        ],[
            'email.required' => Lang::get('account::errors.enter_email'),
            'email.email' => Lang::get('account::errors.enter_valid_email'),
            'password.required' => Lang::get('account::errors.enter_password'),
        ]);

        if($validator->fails()) {
            return $this->json->errors($validator->errors());
        }


        // Authenticate
        try{
            $user = User::where('email', $request->post('email'))->first();

            if($user == null){
                return Lang::get('account::errors.incorrect_credentials');
            }

            if(!Hash::check($request->get('password'), $user->getAuthPassword())){
                return Lang::get('account::errors.incorrect_credentials');
            }

            // Login successful
            UserLoggedInEvent::dispatch($user);


            // Send back user data
            return $this->json->data([
                    'user' => $user,
                    'token' => $user->getAuthToken(),
                ],
                Lang::get('account::success.login_successful')
            );


        }catch(Exception $e){
            return $this->json->error(Lang::get('errors.server'));
        }

    }
}
