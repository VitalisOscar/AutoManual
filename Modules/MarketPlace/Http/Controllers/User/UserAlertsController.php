<?php

namespace Modules\MarketPlace\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Modules\MarketPlace\Events\AlertAddedEvent;
use Modules\MarketPlace\Events\AlertDeletedEvent;
use Modules\MarketPlace\Models\Alert;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Repository\UserAlertsRepository;
use Modules\MarketPlace\Traits\User\ManagesAlerts;

class UserAlertsController extends Controller
{
    use ManagesAlerts;

    public function getAll(UserAlertsRepository $repository){
        return $this->json->data(
            $repository->getUserAlerts($this->user())
        );
    }

    public function add(Request $request){
        // TODO update validation rules
        $validator = validator($request->post(), [
            'maximum_price' => 'nullable|numeric|min:500000',
            'maximum_mileage' => 'nullable|numeric|min:500000',
            'transmission' => 'nullable|in:'.implode(',', Car::TRANSMISSIONS),
            'town' => 'nullable|string',
            'category_id' => 'nullable|exists:'.Category::TABLE_NAME.',id',
            'body_type_id' => 'nullable|exists:'.BodyType::TABLE_NAME.',id',
            'car_make_id' => 'nullable|exists:'.CarMake::TABLE_NAME.',id',
            'car_model_id' => 'nullable|exists:'.CarModel::TABLE_NAME.',id',
        ]);

        if($validator->fails()){
            return $this->json->errors($validator->errors());
        }


        // Create the alert
        DB::beginTransaction();

        $result = $this->createNewAlert($this->user(), $validator->validated());

        if(is_string($result)){
            DB::rollBack();
            return $this->json->error($result);
        }

        // Done
        AlertAddedEvent::dispatch($result);

        DB::commit();
        return $this->json->success(Lang::get('marketplace::success.alert_created'));
    }

    public function delete($alert_id){
        $user = $this->user();

        // Get the alert
        $alert = $user->alerts()->where(Alert::TABLE_NAME.'.id', $alert_id)->first();

        if($alert == null){
            return Lang::get('marketplace::errors.alert_does_not_exist');
        }

        // Delete
        DB::beginTransaction();

        $result = $this->deleteAlert($alert);

        if(is_string($result)){
            DB::rollBack();
            return $this->json->error($result);
        }

        // Done
        AlertDeletedEvent::dispatch($alert);

        DB::commit();
        return $this->json->success(Lang::get('marketplace::success.alert_deleted'));
    }

}
