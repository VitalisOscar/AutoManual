<?php

use App\Models\BodyType;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Alert;

class CreateListingAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Alert::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained(User::TABLE_NAME)->cascadeOnDelete();
            $table->integer('maximum_price')->nullable();
            $table->integer('maximum_mileage')->nullable();
            $table->string('transmission')->nullable();
            $table->string('town')->nullable();
            $table->foreignId('category_id')->nullable()->constrained(Category::TABLE_NAME)->cascadeOnDelete();
            $table->foreignId('body_type_id')->nullable()->constrained(BodyType::TABLE_NAME)->cascadeOnDelete();
            $table->foreignId('car_make_id')->nullable()->constrained(CarMake::TABLE_NAME)->cascadeOnDelete();
            $table->foreignId('car_model_id')->nullable()->constrained(CarModel::TABLE_NAME)->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Alert::TABLE_NAME);
    }
}
