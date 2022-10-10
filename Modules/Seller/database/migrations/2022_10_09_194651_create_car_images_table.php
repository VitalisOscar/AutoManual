<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Seller\Models\Car;
use Modules\Seller\Models\CarImage;

class CreateCarImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CarImage::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('path');
            $table->boolean('is_main')->index();
            $table->foreignId('car_id')->constrained(Car::TABLE_NAME);

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
        Schema::dropIfExists(CarImage::TABLE_NAME);
    }
}
