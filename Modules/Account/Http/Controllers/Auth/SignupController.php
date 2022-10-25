<?php

namespace Modules\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Rules\StrongPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Modules\Account\Events\Auth\UserRegisteredEvent;
use Modules\Account\Models\User;
use Propaganistas\LaravelPhone\PhoneNumber;

class SignupController extends Controller
{

    public function index(Request $request){
        try{
            // Get the country
            $c = strtolower($request->post('country_id', -1));
            $country = Country::whereId($c)->first();

            if($country == null){
                return $this->json->error(Lang::get('account::errors.select_valid_country'));
            }


            // Validate
            $data = $request->post();

            // Format the phone
            $data['phone'] = PhoneNumber::make($data['phone'], $country->code);
            $data['phone'] = str_replace('+', '', $data['phone']);

            $validator = validator($data, [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|unique:'.User::TABLE_NAME.',email',
                'phone' => 'required|unique:'.User::TABLE_NAME.',phone|phone:'.$country->code,
                'password' => ['required', new StrongPassword()],
            ],[
                'first_name.required' => Lang::get('account::errors.enter_fname'),
                'last_name.required' => Lang::get('account::errors.enter_lname'),
                'first_name.string' => Lang::get('account::errors.enter_valid_name'),
                'last_name.string' => Lang::get('account::errors.enter_valid_name'),
                'phone.required' => Lang::get('account::errors.enter_phone'),
                'phone.unique' => Lang::get('account::errors.phone_taken'),
                'phone.phone' => Lang::get('account::errors.enter_valid_phone'),
                'password.required' => Lang::get('account::errors.set_password'),
            ]);

            if($validator->fails()) {
                return $this->json->errors($validator->errors());
            }


            // Create an account
            $data = $validator->validated();

            $user = new User([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone' => $data['phone'],
                'country_id' => $country->id,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if(!$user->save()){
                return $this->json->error(Lang::get('errors.unknown'));
            }

            // Client created, fire event
            UserRegisteredEvent::dispatch($user);

            // Refresh the model
            $user->refresh();

            // Send back user data
            return $this->json->data([
                    'user' => $user,
                    'token' => $user->getAuthToken(),
                ],
                Lang::get('account::success.signup_successful')
            );

        }catch(Exception $e){
            return $this->json->error(Lang::get('errors.server').$e->getMessage());
        }

    }
}
