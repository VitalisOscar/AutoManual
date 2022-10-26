<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Account\Models\User;
use Modules\MarketPlace\Models\Car;
use Modules\MarketPlace\Models\Favorite;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Favorite::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained(User::TABLE_NAME)->cascadeOnDelete();
            $table->foreignId('car_id')->constrained(Car::TABLE_NAME)->cascadeOnDelete();

            $table->unique(['user_id', 'car_id']);

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
        Schema::dropIfExists(Favorite::TABLE_NAME);
    }
}
