<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Account\Models\User;
use Modules\Seller\Models\ProfileType;
use Modules\Seller\Models\Seller;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Seller::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->foreignId('profile_type_id')->constrained(ProfileType::TABLE_NAME);
            $table->foreignId('user_id')->constrained(User::TABLE_NAME);
            $table->json('location');
            $table->string('logo')->nullable();
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
        Schema::dropIfExists(Seller::TABLE_NAME);
    }
}
