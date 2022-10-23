<?php

use App\Models\CarModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToCarModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CarModel::TABLE_NAME, function (Blueprint $table) {
            $table->string('slug')->after('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(CarModel::TABLE_NAME, function (Blueprint $table) {
            //
        });
    }
}
