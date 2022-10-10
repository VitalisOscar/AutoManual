<?php

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CarModel::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('car_make_id')->constrained(CarMake::TABLE_NAME);

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
        Schema::dropIfExists(CarModel::TABLE_NAME);
    }
}
