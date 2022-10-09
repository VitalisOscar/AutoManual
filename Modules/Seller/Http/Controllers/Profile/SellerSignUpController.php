<?php

namespace Modules\Seller\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\Seller\Events\SellerCreatedEvent;
use Modules\Seller\Models\ProfileType;
use Modules\Seller\Traits\CreatesProfiles;

class SellerSignUpController extends Controller
{
    use CreatesProfiles;

    public function index(Request $request){

        // Get the profile type
        /** @var ProfileType */
        $profile_type = ProfileType::where('id', $request->post('type'))->first();

        if($profile_type == null){
            return $this->json->error(Lang::get('seller::errors.type_invalid'));
        }

        // Validate
        if($profile_type->forPersonal()){
            // Validation for personal profiles
            $rules = [
                'location' => 'array|required',
                'location.town' => 'required|string'
            ];
        }else{
            // Validation for dealerships and auto companies
            $rules = [
                'name' => "nullable|string|required",
                'logo' => 'image|max:200kb|mime_types:image/png,image/jpeg,image/jpg|required',
                'location' => 'array|required',
                'location.address' => 'required|string',
                'location.town' => 'required|string',
                'location.lat' => 'nullable|numeric',
                'location.lng' => 'nullable|numeric',
            ];
        }

        // Validate
        $validator = validator($request->all(), $rules, [
            'type.required' => Lang::get('seller::errors.type_required'),
            'type.exists' => Lang::get('seller::errors.type_invalid'),

            'name.required' => Lang::get('seller::errors.name_required_unless'),
            'name.string' => Lang::get('seller::errors.name_invalid'),

            'logo.required' => Lang::get('seller::errors.logo_required'),
            'logo.image' => Lang::get('seller::errors.logo_invalid'),
            'logo.mime_types' => Lang::get('seller::errors.logo_invalid'),
            'logo.max' => Lang::get('seller::errors.logo_too_big', ['max' => 200]),

            'location.address.required' => Lang::get('seller::errors.address_required'),
            'location.address.string' => Lang::get('seller::errors.address_invalid'),
            'location.town.required' => Lang::get('seller::errors.town_required'),
            'location.town.string' => Lang::get('seller::errors.town_invalid'),
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }


        // Create the profile
        DB::beginTransaction();
        $seller = $this->createSellerProfile(
            $this->user(),
            $profile_type,
            $validator->validated()
        );

        if(is_string($seller)){
            DB::rollBack();
            return $this->json->error($seller);
        }

        // Done
        SellerCreatedEvent::dispatch($seller);
        DB::commit();

        return $this->json->success(Lang::get('seller::success.seller_created'));
    }
}
