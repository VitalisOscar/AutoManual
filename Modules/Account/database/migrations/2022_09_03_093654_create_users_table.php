<?php

use App\Models\Country;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Account\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->foreignId('country_id')->constrained(Country::TABLE_NAME);
            $table->timestamp('phone_verified_at')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable()->index();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->index(['phone_verified_at', 'email_verified_at'], 'verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::TABLE_NAME);
    }
}
