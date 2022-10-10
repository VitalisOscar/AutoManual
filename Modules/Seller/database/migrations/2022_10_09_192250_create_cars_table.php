<?php

use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Seller\Models\Car;
use Modules\Seller\Models\Seller;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Car::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->integer('year')->index();
            $table->integer('mileage')->index();
            $table->string('fuel')->index();
            $table->string('transmission')->index();
            $table->string('color');
            $table->text('description')->nullable();
            $table->foreignId('seller_id')->constrained(Seller::TABLE_NAME);
            $table->foreignId('category_id')->constrained(Category::TABLE_NAME);
            $table->foreignId('body_type_id')->constrained(Category::TABLE_NAME);
            $table->foreignId('car_make_id')->constrained(CarMake::TABLE_NAME);
            $table->foreignId('car_model_id')->constrained(CarModel::TABLE_NAME);
            $table->json('features')->nullable();
            $table->string('status')->index();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Car::TABLE_NAME);
    }
}
